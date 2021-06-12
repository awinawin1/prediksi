<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Models\File;

class KlasifikasiController extends Controller
{
    public function index(){
        return view('v_upload');
    }
    public function upload(Request $request){
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');
        // $fileModel = new File;

        $namaFile = $file->getClientOriginalName();
        $filePath = $file->storeAs('uploaded',$namaFile,'public');

        // $fileModel->name = $fileName;
        // $fileModel->filepath = $filePath;
        // $fileModel->save();
        $tujuan_upload = 'uploaded';
        $terupload = $file->move($tujuan_upload,$file->getClientOriginalName());
        if ($terupload) {
            echo "Upload berhasil!<br/>";
            echo "View Data: <a href='" .route('viewData', ['namaFile' => $namaFile])."'> Klik disini</a>";
            echo "<br>Klasifikasi Data: <a href='" .route('klasifikasi', ['namaFile' => $namaFile])."'> Klik disini</a>";
        }
        else {
            echo "Upload Gagal!";
        }
    }

    public function viewData($namaFile){
        $command = escapeshellcmd("python3 ".public_path("code/simpleView.py")." ".public_path("uploaded/".$namaFile));

        $output = shell_exec($command);
        $m = array('msg' => $output);
        print_r($output);
    }

    public function klasifikasi($namaFile){
        // $image_name = public_path("uploaded/".$namaFile);

        // if (!file_exists($image_name)) {
        //        $m=array('msg' => "REJECTED, file tidak ada");
        //        echo json_encode($m);
        //        return;
        //     }
        $command = escapeshellcmd("python3 ".public_path("code/simpleCrop.py")." ". $namaFile);
        $output = shell_exec($command);
        print_r($output);


        // echo(public_path("uploaded/".$namaFile));
        // $output = shell_exec($command);

        // echo json_encode(array($output));
        // echo 'haha';

    }
}