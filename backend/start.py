from pathlib import Path
from main_utils import realTimeFacialLandmarks
from main_utils import smile_detection
from imutils.video import VideoStream
from imutils import face_utils
from keras.models import load_model
from keras.models import model_from_json
import time
import numpy as np
import pandas as pd
import cv2
import dlib
import json
from audio import audio_processing

#######################################
#t = 0
#landmarksArray = []
#smileScore = 0
#row = []
#featureArray = []
#column = ['Average Smile Score','Outer Eyebrow Height','Inner Eyebrow Height','Outer Lip Height','Inner Lip Height','Inner Eyebrow Distance','Lip Corner Distance','Eye Opening']


def start_realTimeVideo(file):
    
    #######################################
    t = 0
    landmarksArray = []
    smileScore = 0
    row = []
    featureArray = []
    column = ['Outer Eyebrow Height','Inner Eyebrow Height','Outer Lip Height','Inner Lip Height','Inner Eyebrow Distance','Lip Corner Distance','Eye Opening','Average Smile Score']

    #######################################
    fourcc = cv2.VideoWriter_fourcc(*'XVID')
    out = cv2.VideoWriter('data_save/output.avi', fourcc, 20.0, (640,480))
    #######################################
    emotion_labels = {0:'Neutral',1:'Neutral',2:'Neutral',3:'Smiling',4:'Neutral',5:'Surprise',6:'Neutral'}
    emotion_classifier = load_model('dependencies/fer2013.hdf5', compile=False)
    emotion_target_size = emotion_classifier.input_shape[1:3]

    face_haarCascade = cv2.CascadeClassifier('dependencies/haarcascade_frontalface_default.xml')
    eye_haarCascade = cv2.CascadeClassifier('dependencies/haarcascade_eye.xml')

    shapePredictorPath = 'dependencies/shape_predictor_68_face_landmarks.dat'
    faceDetector = dlib.get_frontal_face_detector()
    facialLandmarkPredictor = dlib.shape_predictor(shapePredictorPath)
    #######################################


    vs = VideoStream(usePiCamera = False).start()
    
    if file.exists():
        ## write our code for video taking
        while(file.exists()):

            frame = vs.read()
            gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY)
            cv2.equalizeHist(gray)
            faces = faceDetector(gray, 0)

            for (i, face) in enumerate(faces):

                facialLandmarks = facialLandmarkPredictor(gray, face)
                facialLandmarks = face_utils.shape_to_np(facialLandmarks)
                
                (x, y, w, h) = face_utils.rect_to_bb(face)
                cv2.rectangle(frame, (x, y), (x+w, y+h), (0, 255, 0), 2)
                cv2.putText(frame, '#{}'.format(i+1), (x, y-10), cv2.FONT_HERSHEY_SIMPLEX, 0.5, (0, 255, 0), 2)
                
                landmarksArray = realTimeFacialLandmarks.getDistance(facialLandmarks)
                realTimeFacialLandmarks.facialPointJson(t,landmarksArray)

                for (a, b) in facialLandmarks:
                    cv2.circle(frame, (a, b), 1, (0, 0, 255), -1)
                
                ##################################################

                gray_face = smile_detection.processedFace(emotion_target_size,gray,x,y,w,h)
                emotion = smile_detection.predictEmotion(emotion_labels,emotion_classifier,gray_face)
                cv2.putText(frame,emotion, (x, y-25),cv2.FONT_HERSHEY_SIMPLEX, 1, (0, 255, 0), 1,cv2.LINE_AA)

                smileScore = smile_detection.getSmileScore(emotion_classifier,gray_face)
                smile_detection.smileJson(t,smileScore)
                
                ##################################################q
                t = t + 1
                
                temp = landmarksArray
                temp.append(smileScore)
                featureArray.append(temp)
                # print(featureArray)

            out.write(frame)
            cv2.imshow("Frame", frame)

        featureArray = np.array(featureArray)
        print(featureArray)
        for i in range(len(featureArray[0])):
            row.append(round(np.mean(featureArray[:,i])))
        print(row)

        df = pd.DataFrame(data = [row], columns = column)
        df.to_csv('data_save/realtime_video_cues.csv')

        out.release()
        cv2.destroyAllWindows()
        vs.stop()
        
    else:
        print("No file")

#log file is the heart
file=Path("log.txt")

#start realtime video
#start_realTimeVideo(file)

#start audio processing
audio_processing.start_audio(file)