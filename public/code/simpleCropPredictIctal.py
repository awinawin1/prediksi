# -*- coding: utf-8 -*-
"""
Created on Sat May 15 00:21:05 2021

@author: marina
"""

import pyedflib
import numpy as np
import pandas as pd
import sys
import mne 
from pywt import wavedec
from sklearn.preprocessing import LabelEncoder

# pathDataSet = "E:\\TA\\chb-mit-scalp-eeg-database-1.0.0\\chb24\\"
pathDataSet = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/uploadedPrediksi/"


def data_load(FILE, selected_channels=[]):    
    fullNm = pathDataSet + FILE
    #fullNm = FILE
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

def create_modelCNN(input_shape, num_class,flatten=False):
  from tensorflow.keras.models import Sequential
  from tensorflow.keras.layers import Dense
  from tensorflow.keras.backend import clear_session
  from tensorflow.keras.optimizers import Adam
    
  from tensorflow.keras.layers import Conv1D#, Input
  from tensorflow.keras.layers import MaxPooling1D
  from tensorflow.keras.layers import GlobalAveragePooling1D#, GlobalMaxPooling1D
  from keras.layers import Activation,Flatten, Dropout
    
  clear_session()
  model = Sequential()
  def add_conv_block(model, num_filters, input_shape=None):
        if input_shape:
            model.add(Conv1D(num_filters, kernel_size=3, activation='relu', padding='same', input_shape=input_shape))
        else:
            model.add(Conv1D(num_filters, kernel_size=3, activation='relu', padding='same'))
        return model
  model = add_conv_block(model, 128, input_shape=input_shape[1:])
  model = add_conv_block(model, 128)
  model.add(Dropout(0.3))  
  model.add(MaxPooling1D(pool_size=3, # size of the window
                        strides=2,   # factor to downsample
                        padding='same'))
  model.add(Dropout(0.1))
  for i in range(2):
    model.add(Conv1D(filters=256,kernel_size=3,padding="same",activation='relu'))
    model.add(Dropout(0.1))
  if flatten:
    model.add(Flatten())
  else:
    model.add(GlobalAveragePooling1D())
  model.add(Dense(units=128,activation='relu'))
  model.add(Dropout(0.1))
  model.add(Dense(num_class))
  model.add(Activation('softmax'))
  model.compile(optimizer=Adam(0.0001), 
                loss='categorical_crossentropy', 
                metrics=['accuracy'])
  return model

def calculate_statistics(list_values):
    n5 = np.nanpercentile(list_values, 5)
    n25 = np.nanpercentile(list_values, 25)
    n75 = np.nanpercentile(list_values, 75)
    n95 = np.nanpercentile(list_values, 95)
    median = np.nanpercentile(list_values, 50)
    return [n5,n25,n75,n95, median]

def calculate_crossings(list_values):
    zero_crossing_indices = np.nonzero(np.diff(np.array(list_values) > 0))[0]
    no_zero_crossings = len(zero_crossing_indices)
    mean_crossing_indices = np.nonzero(np.diff(np.array(list_values) > np.nanmean(list_values)))[0]
    no_mean_crossings = len(mean_crossing_indices)
    return [no_zero_crossings, no_mean_crossings]
#    return [ no_mean_crossings]

def get_featuresStat(list_values):
    crossings = calculate_crossings(list_values)
    statistics = calculate_statistics(list_values)
    return crossings + statistics


def getFeatureStatWithWavelet(signal,numCH,waveName,level):
    ftrStat=[]
    for x in range(numCH):
        list_coeff  = wavedec(signal[x], waveName,level=level)
        features = []
        for coeff in list_coeff:
            features += get_featuresStat(coeff)
        ftrStat.append(features)    
    return np.array(ftrStat)
  
if __name__ == '__main__':
    FILE=sys.argv[1]
    # FILE = 'chb24_22.edf'
    # FILE = 'chb24_09.edf'
    loaded = np.load("/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/channel_keeps.npz")
    # loaded = np.load("")
    selected_channels =loaded['channel_keeps'] 
    segmen=[]
    
    raw = loadAndFiltering(FILE,selected_channels)
    
    cropData =  Crop(raw)
    waveName,level = 'bior3.1',4
    numCH   = cropData[0].shape[0]
    signal  = cropData[0]
    oneData = getFeatureStatWithWavelet(
                                    signal,numCH,
                                    waveName,level)
    
    
    oneData  = oneData.reshape(1,oneData.shape[0],oneData.shape[1])
    KELAS    = 3
    model    = create_modelCNN(oneData.shape,KELAS)#,False)    
    nmModel  = '/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/modelCNN_3Kelas.h5'
    # nmModel  = ''

    model.load_weights(nmModel)    
    # print(oneData.shape) 
    cnt=0
    label_encoder = LabelEncoder()    
    label_encoder.classes_  = np.load('/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/classes.npy')
    # label_encoder.classes_  = np.load('')
    nmModelInter  = '/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/modelIctal.h5'
    # nmModelInter  = ''
    #KELASInter    =51
    KELASInter    =41
    modelInter    = create_modelCNN(oneData.shape,KELASInter)#,False)    
    modelInter.load_weights(nmModelInter)    
    ictal_alert = 0
    
    for idx in range(cropData.shape[0]): 
        numCH   = cropData[idx].shape[0]
        signal  = cropData[idx]
        oneData     = getFeatureStatWithWavelet(
                                    signal,numCH,
                                    waveName,level)
        oneData  = oneData.reshape(1,oneData.shape[0],oneData.shape[1])

        yPred = model.predict(oneData)
        yPred = np.argmax(yPred,axis=1)
        if yPred[0] == 0:
            hasil = "Normal"
            ictal_alert = 0
        elif yPred[0] == 1:
            hasil = "Inter"            
            yPredTime= modelInter.predict(oneData) 
            yPredTime=np.argmax(yPredTime,axis=1)
            time =  label_encoder.inverse_transform(yPredTime)
            ictal_alert = ictal_alert + 1
            if ictal_alert==3:
                print("Ictal akan terjadi dalam waktu %g detik "%time)                
        else:
            hasil = "Ictal"
            ictal_alert = 0
            # break
        segmen.append(hasil)  
        # print("segment=%d prediksi=%s  "%(idx,hasil))
        cnt+=1
        if cnt>10:
            break
    print(segmen)