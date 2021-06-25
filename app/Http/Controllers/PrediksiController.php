<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prediksi;

class PrediksiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $message ="";
        return view('v_uploadPrediksi',['message'=>$message]);
    }
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        if($ext!="edf"){
            $message = "Hanya Menerima File EDF";
            return view('v_uploadPrediksi',['message'=>$message]);
        }
        $namaFile = $file->getClientOriginalName();
        $filePath = $file->storeAs('uploadedPrediksi',$namaFile,'public');
        $prediksi = new Prediksi;
        $prediksi->filename = $namaFile;
        $prediksi->path =(string) $filePath;
        $prediksi->save();
        $tujuan_upload = 'uploadPrediksi';
        $terupload = $file->move($tujuan_upload,$file->getClientOriginalName());
        if ($terupload) {
            return view('prediksidata',['namaFile' => $namaFile]);
        }
        else {
            echo "Upload Gagal!";
        }
    }
    public function viewData($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile." "."2");

        $output = shell_exec($command);
        $sinyal = "uploadedPrediksi/".$namaFile.".png";
        $kategori = "Prediksi";
        return view('sinyal',['sinyal'=>$sinyal,'namaFile'=>$namaFile,'kategori'=>$kategori]);
    }

    public function prediksi($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleCropPredictIctal.py")." ". $namaFile);
        $output = shell_exec($command);
        $command_predict = escapeshellcmd("python3 ".public_path("code/prediksi.py")." ". $namaFile);
        $index_prediksi = shell_exec($command_predict);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        return view('cropPrediksi',['arrayPrediksi'=>$output,'namaFile'=>$namaFile,'index_prediksi'=>$index_prediksi]);
    }
    public function history($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/historyPrediksi.py")." ". $namaFile);
        $output = shell_exec($command);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        // return $output;
        return view('history',['output'=>$output,'namaFile'=>$namaFile]);
    }
}
