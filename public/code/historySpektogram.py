import sys
pathDataSet = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/uploadedSpektogram/spektogram/"
FILE = sys.argv[1]
bukaFile = open(pathDataSet+FILE+".txt","r")
print(bukaFile.read())