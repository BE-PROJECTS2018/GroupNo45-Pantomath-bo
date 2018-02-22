import time
from pathlib import Path

def start(file):
    
    with open(file,'w') as fwrite:
        fwrite.write("================== Process Started ==================\n")
    
    if file.exists():
        while(file.exists()):
            with open(file,'a') as fwrite:
                fwrite.write("Access:" + time.ctime())
    else:
        print("No file")

file=Path("log.txt")
start(file)