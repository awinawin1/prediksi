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
        return view('v_uploadPrediksi');
    }
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');

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
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile);

        $output = shell_exec($command);
        $m = array('msg' => $output);
        print_r($output);
    }

    public function prediksi($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleCropPredictIctal.py")." ". $namaFile);
        $output = shell_exec($command);
        $output = str_replace("'","",$output);
        $output = str_replace("[","",$output);
        $output = str_replace("]","",$output);
        $output = explode(",",$output);
        $output = str_replace("\n","",$output);
        $output = str_replace(" ","",$output);
        $arrayPrediksi = [];
        $segmen = [];
        for($x=0; $x < count($output);$x++){
            array_push($segmen,(string)$x);
            if($output[$x]=="Normal"){
                array_push($arrayPrediksi,$output[$x]);
            } elseif ($output[$x]=="Inter") {
                array_push($arrayPrediksi,$output[$x]);
            } else {
                array_push($arrayPrediksi,$output[$x]);
            }
        }
        // return $output;
        return view('cropPrediksi',['arrayPrediksi'=>$arrayPrediksi,'segmen'=>$segmen]);
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
