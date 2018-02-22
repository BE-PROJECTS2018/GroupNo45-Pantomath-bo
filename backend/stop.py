import os

def stop(file):

    if os.path.isfile(file):
        try:
            with open(file,'w') as fwrite:
                fwrite.write("================== Process Ended ==================\n")

            os.remove(file)
            print("file removed")
        except OSError:
            print("retrying..")
            stop(file)
    else:
        print("File not there")


stop('log.txt')