# -*- coding: utf-8 -*-
"""
Created on Sat May 15 00:21:05 2021

@author: marina
"""

import pyedflib
import matplotlib
matplotlib.use('WebAgg')
import matplotlib.pyplot as plt,mpld3
import numpy as np
import pandas as pd
import sys
pathDataSet = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/uploaded/"
#pathDataSet =

if __name__ == '__main__':
    file=sys.argv[1]
    # file = 'chb01_01.edf'    
    file = file.replace("'","")
    fullNm = pathDataSet + file   
    # print(fullNm)
    f = pyedflib.EdfReader(fullNm )
    n = f.signals_in_file
    signal_labels = f.getSignalLabels()
    sigbufs = np.zeros((n, f.getNSamples()[0]))
    for i in np.arange(n):
        sigbufs[i, :] = f.readSignal(i)
    f.close()
    
    # and load the data into a DataFrame
    df_signals = pd.DataFrame(sigbufs)
    df_signals = df_signals.transpose()
    df_signals.columns = signal_labels
    df_signals = df_signals.loc[:,~df_signals.columns.duplicated()]

    jmlKolom=len(df_signals.columns)
    # jmlKolom=22
    
    # # EEG Samples
    ax = ['ax'+str(i) for i in range(jmlKolom)]
    C = df_signals.columns

    fig1 = plt.figure(figsize=(12,12))
    detik = 40
    plot_10= 256*detik
    plt.suptitle("Fig: %d detik (256*%d) recorded by 22 channels"%(detik,detik), fontsize= 14)
    for i in range(22): 
        ax[i] = plt.subplot(23,1,i+1)
        ax[i].plot(df_signals[C[i]].iloc[0:plot_10],"blue")
        ax[i].set_xticklabels([])
        ax[i].set_yticklabels([])
        ax[i].tick_params(axis='both', which='both', bottom='off', top='off', labelbottom='off' ,length=0) 
        ax[i].spines["top"].set_visible(False)
        ax[i].spines["bottom"].set_visible(False)
        ax[i].spines["right"].set_visible(False)
        ax[i].spines["left"].set_visible(False)
        # ax[i].set_ylabel(C[i], fontsize=12, rotation=0)
        ax[i].yaxis.set_label_position("right")
    print ('<HTML><HEAD><TITLE>Python Matplotlib Graph</TITLE></HEAD>')
    print ('<BODY>')
    print ('<CENTER>')    
    print ('<H3>Graph</H3>')
    print ('<H3>%s</H3>'%fullNm)
    print (mpld3.fig_to_html(fig1, d3_url=None, mpld3_url=None, no_extras=False, template_type='general', figid=None, use_http=False))
       
    print ('</CENTER>')
    print ('</BODY>')
    print ('</html>')
        
