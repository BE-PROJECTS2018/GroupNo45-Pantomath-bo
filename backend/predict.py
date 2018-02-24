from sklearn import linear_model
from sklearn.svm import SVR
from sklearn.metrics import mean_squared_error
import numpy as np
import csv
import pandas as pd
import matplotlib.pyplot as plt
import re
import json
import os
from sklearn.externals import joblib

def getLabel(filename):

    data = filename.split("(")
    part = data[1].split(")")

    return part[0].replace(" ","_")

def getValue(string):
    length = len(string)

    return string[1:length-1]


def predict():
    # file = '../data_save/features.csv'

    #userData = pd.read_csv('../data_save/features.csv').values

    testAudio = pd.read_csv('data_save/audioCues.csv').values
    testVisual = pd.read_csv('data_save/realtime_video_cues.csv').values

    mergeData = np.append(testVisual[0],testAudio[0,2:])
    #print(mergeData)
    
    jsonData = {}

    directory = os.fsencode(os.getcwd())

    for file in os.listdir(directory):
        filename = os.fsdecode(file) 

        if filename.endswith(".pkl"):
            clf = joblib.load(filename)
            predicted = clf.predict([mergeData[1:]])

            jsonData[getLabel(filename+"")] = getValue(pd.Series(predicted).to_json(orient='values')+"")
        else:
            continue

    #print(jsonData)
    with open('data_save/predictedFeatures.json','w') as jsonFile:
        json.dump(jsonData,jsonFile)
    print("done")

predict()