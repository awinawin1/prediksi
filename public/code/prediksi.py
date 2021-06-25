import sys
pathDataSet = "/Applications/XAMPP/xamppfiles/htdocs/prediksi/storage/app/public/uploadedPrediksi/prediksi/"
FILE = sys.argv[1]
bukaFile = open(pathDataSet+FILE+"prediksi"+".txt","r")
print(bukaFile.read())