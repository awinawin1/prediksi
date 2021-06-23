# -*- coding: utf-8 -*-
"""
Created on Sat May 15 00:21:05 2021

@author: marina
"""
import os
import shutil
import pyedflib
import numpy as np
import pandas as pd
import sys
import mne 
from pywt import wavedec
from sklearn.preprocessing import LabelEncoder
import matplotlib.pyplot as plt
from scipy import signal
from keras.models import Sequential
    #importing layers
from keras.layers import Conv2D,Flatten,Dense,MaxPooling2D    
from tensorflow.keras.optimizers import  SGD
# pathDataSet = "D:\\Kuliah\Tugas Akhir\chb-mit-scalp-eeg-database-1.0.0\\chb07\\"
pathDataSet = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/uploadedSpektogram/"
pathSaveData = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/uploadedSpektogram/spektogram/"


def data_load(FILE, selected_channels=[]):    
    fullNm = pathDataSet + FILE
    # fullNm = FILE
    f = pyedflib.EdfReader(fullNm )
    n = f.signals_in_file
    signal_labels = f.getSignalLabels()
    channel_freq = f.getSampleFrequencies()

    sigbufs = np.zeros((n, f.getNSamples()[0]))
    for i in np.arange(n):
        sigbufs[i, :] = f.readSignal(i)
    f.close()
    
    # and load the data into a DataFrame
    df_signals = pd.DataFrame(sigbufs)
    df_signals = df_signals.transpose()
    df_signals.columns = signal_labels
    df_signals = df_signals.loc[:,~df_signals.columns.duplicated()]
    df_signals = df_signals[selected_channels].astype('float32')      
    return df_signals,channel_freq[0]

def mne_object(data, freq, events = None):
  info = mne.create_info(ch_names=list(data.columns), 
                         sfreq=freq, 
                         ch_types=['eeg']*data.shape[-1])
  data_T = data.transpose()
  raw = mne.io.RawArray(data_T, info,verbose=False)
  if events:
    start_times = np.array(events[::2])
    end_times = np.array(events[1::2])
    anno_length = end_times-start_times
    event_name = np.array(['Ictal']*len(anno_length))
    raw.set_annotations(mne.Annotations(start_times,
                                      anno_length,
                                      event_name))
  return raw

def loadAndFiltering(FILE,channel_keeps):
    raw_data, freq = data_load(FILE, channel_keeps)
    if len(raw_data) ==0:
        print("no data ")
        return raw_data
    mne_data = mne_object(raw_data, freq)
    raw=mne_data.copy()
    return raw

def extract_windows(array, start, max_time, sub_window_size,
                          stride_size):  
    sub_windows = (
        start + 
        np.expand_dims(np.arange(sub_window_size), 0) +
        np.expand_dims(np.arange(max_time + 1- sub_window_size-start, step=stride_size), 0).T
    )   
    return array[:,sub_windows]


def Crop(raw): 
    cropS = 3
    strides = 1
    
    tMin=0
    tMax=raw.get_data().shape[1]#18*256*cropS   


    sub_window_size,stride_size = 256*cropS,256*strides
    cropData = extract_windows(raw.get_data(), tMin, tMax  , sub_window_size,stride_size)
    cropData = cropData.reshape(cropData.shape[1],cropData.shape[0],cropData.shape[2])
    
    return cropData

# def create_modelCNN(input_shape, num_class,flatten=False):
#   from tensorflow.keras.models import Sequential
#   from tensorflow.keras.layers import Dense
#   from tensorflow.keras.backend import clear_session
#   from tensorflow.keras.optimizers import Adam
    
#   from tensorflow.keras.layers import Conv1D#, Input
#   from tensorflow.keras.layers import MaxPooling1D
#   from tensorflow.keras.layers import GlobalAveragePooling1D#, GlobalMaxPooling1D
#   from keras.layers import Activation,Flatten, Dropout
    
#   clear_session()
#   model = Sequential()
#   def add_conv_block(model, num_filters, input_shape=None):
#         if input_shape:
#             model.add(Conv1D(num_filters, kernel_size=3, activation='relu', padding='same', input_shape=input_shape))
#         else:
#             model.add(Conv1D(num_filters, kernel_size=3, activation='relu', padding='same'))
#         return model
#   model = add_conv_block(model, 128, input_shape=input_shape[1:])
#   model = add_conv_block(model, 128)
#   model.add(Dropout(0.3))  
#   model.add(MaxPooling1D(pool_size=3, # size of the window
#                         strides=2,   # factor to downsample
#                         padding='same'))
#   model.add(Dropout(0.1))
#   for i in range(2):
#     model.add(Conv1D(filters=256,kernel_size=3,padding="same",activation='relu'))
#     model.add(Dropout(0.1))
#   if flatten:
#     model.add(Flatten())
#   else:
#     model.add(GlobalAveragePooling1D())
#   model.add(Dense(units=128,activation='relu'))
#   model.add(Dropout(0.1))
#   model.add(Dense(num_class))
#   model.add(Activation('softmax'))
#   model.compile(optimizer=Adam(0.0001), 
#                 loss='categorical_crossentropy', 
#                 metrics=['accuracy'])
#   return model

def modelCNN2(input_shape,nb_classes):
    model = Sequential()
    model.add(Conv2D(32, (3, 3), activation='relu', padding='same', input_shape=input_shape))
    model.add(Conv2D(32, (3, 3), activation='relu', padding='same'))
    model.add(MaxPooling2D((2, 2)))
    model.add(Conv2D(64, (3, 3), activation='relu', padding='same'))
    model.add(Conv2D(64, (3, 3), activation='relu', padding='same'))
    model.add(MaxPooling2D((2, 2)))
    model.add(Conv2D(128, (3, 3), activation='relu', padding='same'))
    model.add(Conv2D(128, (3, 3), activation='relu', padding='same'))
    model.add(MaxPooling2D((2, 2)))
    model.add(Flatten())
    model.add(Dense(128, activation='relu'))
    model.add(Dense(nb_classes, activation='softmax'))
	# compile model
    opt = SGD(lr=0.001, momentum=0.9)
    model.compile(optimizer=opt, loss='categorical_crossentropy', metrics=['accuracy'])
    return model

def plotSpektogram(x,fs,nmFile=''):
    f, t, Sxx = signal.spectrogram(x, fs)
    cut=10
    imgAll=[]
    for i,sinyal in enumerate(Sxx):
        img = plt.pcolormesh(t, f[:cut], sinyal[:cut], shading='gouraud')
        imgAll.append([(r, g, b) for r, g, b, a in img.to_rgba(img.get_array())])
    # print(nmFile)
    if nmFile !='':
         #(18, 30, 3)
        # print("masuk sini")
        plt.savefig(nmFile)
        # plt.show()
        # plt.imsave(nmFile, imgAll)
    
    # imgAll = np.array(imgAll)# .reshape(-1,3)
    imgAll = np.array(imgAll).ravel()
    #(18, 30, 3)
    return imgAll 
    
if __name__ == '__main__':
    FILE=sys.argv[1]
    # FILE = 'D:\\Kuliah\Tugas Akhir\chb-mit-scalp-eeg-database-1.0.0\\chb24\\chb24_22.edf'
    # FILE = 'chb07_12.edf'
    FILE = FILE.replace("'","")
    dir_path = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/fitur3Kelas30DetikImg/"
    if(os.path.isdir(dir_path+FILE)):
        shutil.rmtree(dir_path+FILE)
    os.mkdir("/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/fitur3Kelas30DetikImg/"+FILE,0o777)
    loaded = np.load("/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/channel_keeps.npz")
    selected_channels =loaded['channel_keeps'] 
    segmen=[]
    raw = loadAndFiltering(FILE,selected_channels)
    
    cropData =  Crop(raw)    
    numCH    =  cropData[0].shape[0]
    oneData  =  cropData[0]
    oneData  =  plotSpektogram(oneData,256)
    
    oneData  = oneData.reshape(1,numCH,-1, 3)
    KELAS    = 3
    bntk_input = (18, 30, 3)
    model = modelCNN2(bntk_input,KELAS)
    # model    = modelCNN2(oneData.shape,KELAS)#,False)    
    nmModel  = '/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/modelCNNSpektrogram_3.h5'

    model.load_weights(nmModel)    
    cnt=0    
    
    for idx in range(cropData.shape[0]): 
        numCH   = cropData[idx].shape[0]
        oneData = cropData[idx]
        nmFile  = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/fitur3Kelas30DetikImg/%s/%s_%d.png"%(FILE,FILE,idx)
        # nmFile = dir+"%s_%s.png"%(FILE,idx)
        oneData = plotSpektogram(oneData,256,nmFile)
        oneData = oneData.reshape(1,numCH,-1, 3)
        yPred   = model.predict(oneData)
        yPred   = np.argmax(yPred,axis=1)
        if yPred[0] == 0:
            hasil = "Normal"
        elif yPred[0] == 1:
            hasil = "Inter"            
        else:
            hasil = "Ictal"
            # break
        segmen.append(hasil)    
        # print("segment=%d prediksi=%s  <br>"%(idx,hasil))
        cnt+=1
        if cnt>5:
            break
    saveHistory = open(pathSaveData+FILE+".txt","w")
    saveHistory.write(str(segmen))
    saveHistory.close()
    print(segmen)
        
        
    
    

