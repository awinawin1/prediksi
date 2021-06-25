<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klasifikasi;

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
        $filePath = $file->storeAs('uploaded',$namaFile,'public');

        $klasifikasi = new Klasifikasi;
        $klasifikasi->filename = $namaFile;
        $klasifikasi->path =(string) $filePath;
        $klasifikasi->save();
        $tujuan_upload = 'uploaded';
        $terupload = $file->move($tujuan_upload,$file->getClientOriginalName());
        if ($terupload) {
            return view('klasifikasidata',['namaFile' => $namaFile]);
        }
        else {
            echo "Upload Gagal!";
        }
    }

    public function viewData($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile." "."1");

        $output = shell_exec($command);
        $sinyal = "uploaded/".$namaFile.".png";
        $kategori = "Klasifikasi";
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
        return view('history',['output'=>$output,'namaFile'=>$namaFile]);
    }
}