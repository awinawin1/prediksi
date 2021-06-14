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
            echo "Upload berhasil!<br/>";
            echo "View Data: <a href='" .route('viewDataSpektogram', ['namaFile' => $namaFile])."'> Klik disini</a>";
            echo "<br>Klasifikasi Spektogram Data: <a href='" .route('spektogram', ['namaFile' => $namaFile])."'> Klik disini</a>";
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
        print_r($output);
    }
}
