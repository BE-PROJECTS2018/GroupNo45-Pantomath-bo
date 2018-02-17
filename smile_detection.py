import cv2
import numpy as np
import pandas as pd
from keras.models import load_model
from keras.models import model_from_json
import json
from moviepy.editor import VideoFileClip
import matplotlib.animation as animation
import time
import matplotlib.pyplot as plt
import json

t = 0
t1 = 0
ysmile = []
xsmile = []
xsm = 0
ysm = 0
fourcc = cv2.VideoWriter_fourcc(*'XVID')
out = cv2.VideoWriter('output.avi', fourcc, 20.0, (640,480))


# emotion_labels = {0:'angry',1:'disgust',2:'fear',3:'happy',4:'sad',5:'surprise',6:'neutral'}
emotion_labels = {0:'Neutral',1:'Neutral',2:'Neutral',3:'Smiling',4:'Neutral',5:'Surprise',6:'Neutral'}
emotion_classifier = load_model('fer2013.hdf5', compile=False)
emotion_target_size = emotion_classifier.input_shape[1:3]

face_haarCascade = cv2.CascadeClassifier('haarcascade_frontalface_default.xml')
eye_haarCascade = cv2.CascadeClassifier('haarcascade_eye.xml')

cv2.namedWindow('Video')
cam_capture = cv2.VideoCapture(0)

while True:
	ret, img = cam_capture.read()
	out.write(img)
	gray_img = cv2.cvtColor(img, cv2.COLOR_BGR2GRAY)
	cv2.equalizeHist(gray_img)
	#img_gray = cv2.cvtColor(frame, cv2.COLOR_BGR2GRAY,1)
	faces = face_haarCascade.detectMultiScale(
        gray_img,
        scaleFactor=1.3,
        minNeighbors=5,
        minSize=(30, 30),
    )

	for(x,y,w,h) in faces:
		#####
		eyes = eye_haarCascade.detectMultiScale(
			gray_img,
			scaleFactor=1.3,
			minNeighbors=5,
		)
		for(a,b,c,d) in eyes:
			color = np.asarray((0, 255, 0))
			color = color.astype(int)
			color = color.tolist()
			cv2.rectangle(img, (a,b), (a+c, b+d), color, 2)

		face_image_gray = gray_img[y:y+h, x:x+w]
		try:
			face_image_gray = cv2.resize(face_image_gray, (emotion_target_size))
		except:
			continue

		face_image_gray = face_image_gray.astype('float32')
		face_image_gray = face_image_gray / 255.0
		face_image_gray = face_image_gray - 0.5
		face_image_gray = face_image_gray * 2.0
		face_image_gray = np.expand_dims(face_image_gray, 0)
		face_image_gray = np.expand_dims(face_image_gray, -1)
	
		#####

		emotion_prediction = emotion_classifier.predict(face_image_gray)
		# print(emotion_prediction)
		emotion_probability = np.max(emotion_prediction)
		emotion_label_arg = np.argmax(emotion_prediction)
		emotion_text = emotion_labels[emotion_label_arg]
		
		print('{}:{}'.format(emotion_labels[3],emotion_prediction[0,3]*100))	
		ysmile.append(round(emotion_prediction[0,3]*100))	
		xsmile.append(t)
		ysm = round(emotion_prediction[0,3]*100)
		
		t=t+1

		color = np.asarray((225, 255, 0))
		color = color.astype(int)
		color = color.tolist()

		cv2.rectangle(img, (x,y), (x+w, y+h), color, 2)
		cv2.putText(img, emotion_text, (x+0, y-20), cv2.FONT_HERSHEY_SIMPLEX, 1, color, 1, cv2.LINE_AA)

	###############################################
	xsm = t1
	t1 = t1 + 1
	a = np.array(xsmile)
	b = np.array(ysmile)
	plot_smile = {"x":xsm,"series": {"mySeries": ysm}}
	with open('plot_smile.json', 'w') as out_json:
		json.dump(plot_smile, out_json)
	np.save('a.npy', a)
	np.save('b.npy', b)

	cv2.imshow('Video', img)
	if cv2.waitKey(1) & 0xFF == ord('q'):
	    break

	###############################################

cam_capture.release()
cv2.destroyAllWindows()
out.release()
cv2.destroyAllWindows()

meanSmile = np.mean(ysmile)
smile = np.array(meanSmile)
np.save('AvgSmile.npy', smile)

# df = pd.DataFrame(meanSmile, index =['2'], columns = ['Average Smile'])
# df.to_csv('facialCues.csv')



