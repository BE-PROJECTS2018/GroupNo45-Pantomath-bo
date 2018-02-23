import pandas as pd

a = pd.read_csv("data_save/audioCues.csv")
a=a[['Length','Average Band Energy','Avg Intensity','Max Intensity','Mean Intensity','Range Intensity',
'SD Intensity','Avg Pitch','Max Pitch','Mean Pitch','Range Pitch','SD Pitch','Mean F1','Mean F2',
'Mean F3','Mean B1','Mean B2','Mean B3','SD F1','SD F2','SD F3','Mean F2/F1','Mean F3/F1','SD F2/F1','SD F3/F1']]
b = pd.read_csv("data_save/realtime_video_cues.csv")

b = b.dropna(axis=1)

merged = b.merge(a)
merged.to_csv("output.csv", index=False)