<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SpektogramController extends Controller
{
    public function index(){
        return view('v_uploadSpektogram');
    }
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');
        $namaFile = $file->getClientOriginalName();
        $filePath = $file->storeAs('uploadedSpektogram',$namaFile,'public');
        $tujuan_upload = 'uploadedSpektogram';
        $terupload = $file->move($tujuan_upload,$file->getClientOriginalName());
        if ($terupload) {
            return view('spektogramdata',['namaFile' => $namaFile]);
        }
        else {
            echo "Upload Gagal!";
        }
    }

    public function viewData($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".public_path("uploadedSpektogram/".$namaFile));

        $output = shell_exec($command);
        $m = array('msg' => $output);
        print_r($output);
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
        $arraySpektogram = [];
        $segmen = [];
        for($x=0; $x < count($output);$x++){
            array_push($segmen,(string)$x);
            if($output[$x]=="Normal"){
                array_push($arraySpektogram,"1");
            } elseif ($output[$x]=="Inter") {
                array_push($arraySpektogram,"2");
            } else {
                array_push($arraySpektogram,"3");
            }
        }
        // return $output;
        return view('cropSpektogram',['arraySpektogram'=>$arraySpektogram,'segmen'=>$segmen]);
    }
}
