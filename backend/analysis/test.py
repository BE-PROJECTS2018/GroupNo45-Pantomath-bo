from sklearn import linear_model
from sklearn.svm import SVR
from sklearn.metrics import mean_squared_error
import numpy as np
import csv
import pandas as pd
import matplotlib.pyplot as plt
import re
import os
from sklearn.externals import joblib

testAudio = pd.read_csv('features.csv').values

#merge = Audio+video
folder_lasso = '\\lasso'
folder_svr = '\\svr'
folder_ridge = "\\ridge"

directory = os.fsencode(os.getcwd())

for file in os.listdir(directory):
    filename = os.fsdecode(file) 

    if filename.endswith(".pkl"): 
        clf = joblib.load(filename)
        predicted = clf.predict([testAudio[1,1:]])

        print(filename)
        print(predicted)
        # index +=1
    else:
        continue
