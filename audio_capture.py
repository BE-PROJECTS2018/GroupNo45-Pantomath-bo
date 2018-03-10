import pyaudio
import wave
from pathlib import Path
 



def start_audio_capture(file):
    
    FORMAT = pyaudio.paInt16
    CHANNELS = 2
    RATE = 44100
    CHUNK = 1024
    RECORD_SECONDS = 10
    WAVE_OUTPUT_FILENAME = "data_save/file.wav"

    if file.exists():
        audio = pyaudio.PyAudio()
    
        # start Recording
        stream = audio.open(format=FORMAT, channels=CHANNELS,
                        rate=RATE, input=True,
                        frames_per_buffer=CHUNK)
        print("recording...")
        frames = []
        
        while(file.exists()):
            data = stream.read(CHUNK)
            frames.append(data)

        print("finished recording")
        
        
        # stop Recording
        stream.stop_stream()
        stream.close()
        audio.terminate()
        
        waveFile = wave.open(WAVE_OUTPUT_FILENAME, 'wb')
        waveFile.setnchannels(CHANNELS)
        waveFile.setsampwidth(audio.get_sample_size(FORMAT))
        waveFile.setframerate(RATE)
        waveFile.writeframes(b''.join(frames))
        waveFile.close()
    else:
        print("file not exist")

file=Path("log.txt")
start_audio_capture(file)