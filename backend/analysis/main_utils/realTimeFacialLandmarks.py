import math
import json

landmarksArray = []

def getAverageValueFacialPoint(temp):
	array = np.array(temp)
	# print('array',array)
	for i in range(len(array[0])):
		row.append(np.mean(array[:,i]))

	return row

def facialPointJson(x,array):
	plot_facialPoint = {"x":x,"series": {"OBH": array[0],"IBH": array[1],"OLH": array[2],"ILH": array[3],"IED": array[4],"LCD": array[5],"EO": array[6]}}
	with open('data_save/plot_facialPoint.json', 'w') as fp_json:
		json.dump(plot_facialPoint, fp_json)

def ptDistanceFromLine(p,p1,p2):
	# d = abs( (p2[1] - p1[1])*p[1] - (p2[0] - p1[0])*p[0] + p2[0]*p1[1] - p2[1]*p1[0] ) / math.sqrt( math.pow(p2[1]-p1[1], 2) + math.pow(p2[0]-p1[0], 2) )
	d = abs( (p2[0] - p1[0])*p[1] - (p2[1] - p1[1])*p[0] + (p2[1] - p1[1])*p1[0] - (p2[0] - p1[0])*p1[1] ) / math.sqrt( math.pow(p2[1]-p1[1], 2) + math.pow(p2[0]-p1[0], 2) )
	return d
	
def twoPtDistance(p1,p2):
	d = math.sqrt( math.pow(p2[1]-p1[1], 2) + math.pow(p2[0]-p1[0], 2) )
	return d

def getDistance(landmarks):
	OBH = ptDistanceFromLine(landmarks[17],landmarks[36],landmarks[39])
	print('OBH: ',round(OBH))	
	IBH = ptDistanceFromLine(landmarks[21],landmarks[36],landmarks[39])
	print('IBH: ',round(IBH))	
	OLH = ptDistanceFromLine(landmarks[51],landmarks[58],landmarks[57])
	print('OLH: ',round(OLH))
	ILH = ptDistanceFromLine(landmarks[62],landmarks[67],landmarks[65])
	print('ILH: ',round(ILH))
	IED = twoPtDistance(landmarks[21],landmarks[22])
	print('IED: ',round(IED))	
	LCD = twoPtDistance(landmarks[48],landmarks[54])
	print('LCD: ',round(LCD))	
	EO = twoPtDistance(landmarks[43],landmarks[47])
	print('EO: ',round(EO))

	landmarksArray = [round(OBH), round(IBH), round(OLH), round(ILH), round(IED), round(LCD), round(EO)]
	# print(temp)
	return landmarksArray