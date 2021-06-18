<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrediksiController extends Controller
{
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
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".public_path("uploadedPrediksi/".$namaFile));

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
                array_push($arrayPrediksi,"1");
            } elseif ($output[$x]=="Inter") {
                array_push($arrayPrediksi,"2");
            } else {
                array_push($arrayPrediksi,"3");
            }
        }
        // return $output;
        return view('cropPrediksi',['arrayPrediksi'=>$arrayPrediksi,'segmen'=>$segmen]);
    }
}
