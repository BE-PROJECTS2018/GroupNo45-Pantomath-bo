import cv2
import numpy as np
import json

def smileJson(x,smile):
	plot_facialPoint = {"x":x,"series": {"smile": smile}}
	with open('data_save/plot_smile.json', 'w') as smile_json:
		json.dump(plot_facialPoint, smile_json)
	

def processedFace(emotion_target_size,gray_img,x,y,w,h):
	face_image_gray = gray_img[y:y+h, x:x+w]
	try:
		face_image_gray = cv2.resize(face_image_gray, (emotion_target_size))
	except:
		print('None')

	face_image_gray = face_image_gray.astype('float32')
	face_image_gray = face_image_gray / 255.0
	face_image_gray = face_image_gray - 0.5
	face_image_gray = face_image_gray * 2.0
	face_image_gray = np.expand_dims(face_image_gray, 0)
	face_image_gray = np.expand_dims(face_image_gray, -1)

	return face_image_gray

def predictEmotion(emotion_labels,emotion_classifier,face_image_gray):
	emotion_prediction = emotion_classifier.predict(face_image_gray)
		# print(emotion_prediction)
	emotion_probability = np.max(emotion_prediction)
	emotion_label_arg = np.argmax(emotion_prediction)
	emotion_text = emotion_labels[emotion_label_arg]
	print('{}:{}'.format(emotion_labels[3],emotion_prediction[0,3]*100))

	return emotion_text

def getSmileScore(emotion_classifier,face_image_gray):
	emotion_prediction = emotion_classifier.predict(face_image_gray)
	
	return round(emotion_prediction[0,3]*100)

