<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Klasifikasi;
use App\Models\Pasien;

class KlasifikasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $message="";
        return view('v_uploadKlasifikasi',['message'=>$message]);
    }
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');
        $ext = $file->getClientOriginalExtension();
        if($ext!="edf"){
            $message = "Hanya Menerima File EDF";
            return view('v_uploadKlasifikasi',['message'=>$message]);
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
        $filePath = $file->storeAs('uploaded',$namaFile,'public');

        $klasifikasi = new Klasifikasi;
        $klasifikasi->filename = $namaFile;
        $klasifikasi->path =(string) $filePath;
        $klasifikasi->save();
        $tujuan_upload = 'uploaded';
        $terupload = $file->move($tujuan_upload,$file->getClientOriginalName());
        if ($terupload) {
            return view('klasifikasidata',['namaFile' => $namaFile,'age'=>$age,'gender'=>$gender,'seizure'=>$seizure,'ictal'=>$ictal,'inter'=>$inter]);
        }
        else {
            echo "Upload Gagal!";
        }
    }

    public function viewData($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile." "."1");

        $output = shell_exec($command);
        $sinyal = "uploaded/".$namaFile.".png";
        $kategori = "klasifikasi";
        return view('sinyal',['sinyal'=>$sinyal,'namaFile'=>$namaFile,'kategori'=>$kategori]);
    }

    public function klasifikasi($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleCrop.py")." ". $namaFile);
        $output = shell_exec($command);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        return view('cropKlasifikasi',['arrayKlasifikasi'=>$output,'namaFile'=>$namaFile]);
    }
    public function historyDashboard()
    {
        //
    }
    public function history($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/historyKlasifikasi.py")." ". $namaFile);
        $output = shell_exec($command);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        $deskripsi ="Kondisi normal adalah kondisi disaat gelombang otak normal. Inter adalah kondisi otak sebelum terjadinya epilepsi. Dan ictal adalah kondisi yang menandakan pasien sedang mengalamni kejang. 1 Segmen sama dengan tiga detik. 
        Sinyal ".$namaFile." terklasifikasi menggunakan wavelet dalam tiga kategori yaitu normal, inter, dan ictal. Hasil klasifikasi sinyal ".$namaFile." dapat dilihat pada grafik dibawah. Untuk memfokuskan pada grafik dapat menarik garis pada dibawah grafik.";
        return view('history',['output'=>$output,'namaFile'=>$namaFile,'deskripsi'=>$deskripsi]);
    }
}