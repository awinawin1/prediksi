<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Prediksi;
use App\Models\Pasien;

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
        $data_pasien = substr($namaFile,0,5);
        $age = DB::table('pasiens')->where('subject',$data_pasien)->value('age');
        $gender = DB::table('pasiens')->where('subject',$data_pasien)->value('gender');
        if ($gender=="F") {
            $gender="perempuan";
        }else {
            $gender="laki-laki";
        }
        $seizure = DB::table('pasiens')->where('subject',$data_pasien)->value('seizure');
        $ictal = DB::table('pasiens')->where('subject',$data_pasien)->value('ictal');
        $inter = DB::table('pasiens')->where('subject',$data_pasien)->value('inter');
        $filePath = $file->storeAs('uploadedPrediksi',$namaFile,'public');
        $prediksi = new Prediksi;
        $prediksi->filename = $namaFile;
        $prediksi->path =(string) $filePath;
        $prediksi->save();
        $tujuan_upload = 'uploadPrediksi';
        $terupload = $file->move($tujuan_upload,$file->getClientOriginalName());
        if ($terupload) {
            return view('prediksidata',['namaFile' => $namaFile,'age'=>$age,'gender'=>$gender,'seizure'=>$seizure,'ictal'=>$ictal,'inter'=>$inter]);
        }
        else {
            echo "Upload Gagal!";
        }
    }
    public function viewData($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile." "."2");

        $output = shell_exec($command);
        $sinyal = "uploadedPrediksi/".$namaFile.".png";
        $kategori = "prediksi";
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
        $command_predict = escapeshellcmd("python3 ".public_path("code/prediksi.py")." ". $namaFile);
        $index_prediksi = shell_exec($command_predict);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        $deskripsi ="Prediksi dilakukan untuk bersiap sebelum pasien mengalami kejang epilepsi. Kondisi normal adalah kondisi disaat gelombang otak normal. Inter adalah kondisi otak sebelum terjadinya epilepsi. Dan ictal adalah kondisi yang menandakan pasien sedang mengalami kejang. Satu segmen sama dengan tiga detik. Kejang akan terjadi 297 detik setelah segmen ".$index_prediksi.". Untuk melihat lebih detail dapat melakukan zoom ke titik yang ingin dilihat dengan menarik bar kecil dibawah grafik.";
        return view('history',['output'=>$output,'namaFile'=>$namaFile,'deskripsi'=>$deskripsi]);
    }
}
