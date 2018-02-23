import time
import matplotlib.pyplot as plt
# from smile_detection import xmile,ysmile
import numpy as np
import matplotlib.animation as animation
import seaborn
seaborn.set()

fig = plt.figure()
ax1 = fig.add_subplot(1,1,1)

def animate(i):
	xsmile = np.array([0])
	ysmile = np.array([0])
	try:
		xsmile = np.load('../data_save/a.npy')
		ysmile = np.load('../data_save/b.npy')
		# print(xsmile)
		# ax1.clear()
		# ax1.plot(xsmile,ysmile)
	except:
		print("No")

	ax1.clear()
	ax1.plot(xsmile,ysmile)

ani = animation.FuncAnimation(fig, animate, interval=1000)
plt.show()

# import matplotlib.pyplot as plt
# import matplotlib.animation as animation
# import time

# fig = plt.figure()
# ax1 = fig.add_subplot(1,1,1)

# def animate(i):
#     pullData = open("file.txt","r").read()
#     dataArray = pullData.split('\n')
#     xar = []
#     yar = []
#     for eachLine in dataArray:
#         if len(eachLine)>1:
#             x,y = eachLine.split(',')
#             xar.append(int(x))
#             yar.append(int(y))
#     ax1.clear()
#     ax1.plot(xar,yar)
# ani = animation.FuncAnimation(fig, animate, interval=1000)
# plt.show()