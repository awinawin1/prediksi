<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Spektogram;
use App\Models\Pasien;

class SpektogramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $message ="";
        return view('v_uploadSpektogram',['message'=>$message]);
    }
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        if($ext!="edf"){
            $message = "Hanya Menerima File EDF";
            return view('v_uploadSpektogram',['message'=>$message]);
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
        $filePath = $file->storeAs('uploadedSpektogram',$namaFile,'public');
        $spektogram = new Spektogram;
        $spektogram->filename = $namaFile;
        $spektogram->path =(string) $filePath;
        $spektogram->save();
        $tujuan_upload = 'uploadedSpektogram';
        $terupload = $file->move($tujuan_upload,$file->getClientOriginalName());
        if ($terupload) {
            return view('spektogramdata',['namaFile' => $namaFile,'age'=>$age,'gender'=>$gender,'seizure'=>$seizure,'ictal'=>$ictal,'inter'=>$inter]);
        }
        else {
            echo "Upload Gagal!";
        }
    }

    public function viewData($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile." "."3");

        $output = shell_exec($command);
        $sinyal = "uploadedSpektogram/".$namaFile.".png";
        $kategori = "spektogram";
        return view('sinyal',['sinyal'=>$sinyal,'namaFile'=>$namaFile,'kategori'=>$kategori]);
    }

    public function spektogram($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleCropPredictSpektogram.py")." ". $namaFile);
        $output = shell_exec($command);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        return view('cropSpektogram',['arraySpektogram'=>$output,'namaFile'=>$namaFile]);
    }
    public function history($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/historySpektogram.py")." ". $namaFile);
        $output = shell_exec($command);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        $kategori = "spektogram";
        $deskripsi ="Kondisi normal adalah kondisi disaat gelombang otak normal. Inter adalah kondisi otak sebelum terjadinya epilepsi. Dan ictal adalah kondisi yang menandakan pasien sedang mengalami kejang. Satu segmen sama dengan tiga detik. Pada setiap segmen terdapat gambar spectrum yang dapat dilihat. 
        Untuk melihat gambar spektogram yang dihasilkan pada setiap kondisi, silahkan tekan titik pada grafik untuk melihat gambar spektogram pada saat tersebut. Untuk melihat lebih detail dapat melakukan zoom ke titik yang ingin dilihat dengan menarik bar kecil dibawah grafik.";
        return view('riwayatSpektogram',['output'=>$output,'namaFile'=>$namaFile,'deskripsi'=>$deskripsi,'kategori'=>$kategori]);
    }
    public function imageSpektogram($namaFile,$index)
    {
        $spektogramFile = $namaFile."/".$namaFile."_".$index.".png";
        // return $url;
        return view('imageSpektogram',['spektogramFile'=>$spektogramFile,'namaFile'=>$namaFile,'segmen'=>$index]);
    }
    public function historySpektogram($namaFile)
    {
        $dir = storage_path("app/public/fitur3Kelas30DetikImg/".$namaFile."/");
        $images = glob($dir."*.png");
        // print_r($dir);
        return view('riwayatgambar',['spekto'=>$images]);
    }
    public function riwayatgambar($namaFile)
    {
        return view('riwayatgambar',['namaFile'=>$namaFile]);
    }
}
