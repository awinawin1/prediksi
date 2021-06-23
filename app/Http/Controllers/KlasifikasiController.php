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
        return view('v_uploadKlasifikasi');
    }
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');
        // $fileModel = new File;
        $namaFile = $file->getClientOriginalName();
        $filePath = $file->storeAs('uploaded',$namaFile,'public');

        $klasifikasi = new Klasifikasi;
        $klasifikasi->filename = $namaFile;
        $klasifikasi->path =(string) $filePath;
        $klasifikasi->save();
        // $fileModel->name = $fileName;
        // $fileModel->filepath = $filePath;
        // $fileModel->save();
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
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile);

        $output = shell_exec($command);
        $m = array('msg' => $output);
        print_r($output);
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
        $arrayKlasifikasi = [];
        $segmen = [];
        for($x=0; $x < count($output);$x++){
            array_push($segmen,(string)$x);
            if($output[$x]=="Normal"){
                array_push($arrayKlasifikasi,$output[$x]);
            } elseif ($output[$x]=="Interiktal") {
                array_push($arrayKlasifikasi,$output[$x]);
            } else {
                array_push($arrayKlasifikasi,$output[$x]);
            }
        }
        // return $output;
        return view('cropKlasifikasi',['arrayKlasifikasi'=>$arrayKlasifikasi,'segmen'=>$segmen]);
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
        // return $output;
        return view('history',['output'=>$output,'namaFile'=>$namaFile]);
    }
}