<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Spektogram;

class SpektogramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
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
        $spektogram = new Spektogram;
        $spektogram->filename = $namaFile;
        $spektogram->path =(string) $filePath;
        $spektogram->save();
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
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".$namaFile);

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
                array_push($arraySpektogram,$output[$x]);
            } elseif ($output[$x]=="Interiktal") {
                array_push($arraySpektogram,$output[$x]);
            } else {
                // Ictal
                array_push($arraySpektogram,$output[$x]);
            }
        }
        // return $output;
        return view('cropSpektogram',['arraySpektogram'=>$arraySpektogram,'segmen'=>$segmen,'namaFile'=>$namaFile]);
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
        // return $output;
        return view('history',['output'=>$output,'namaFile'=>$namaFile]);
    }
    public function imageSpektogram($namaFile,$index)
    {
        $spektogramFile = $namaFile."/".$namaFile."_".$index.".png";
        // return $url;
        return view('imageSpektogram',['spektogramFile'=>$spektogramFile]);
    }
}
