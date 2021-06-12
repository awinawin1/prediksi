<?php

namespace App\Http\Controllers;
use DB;
use Illuminate\Http\Request;
use App\Models\Uploadedf;
use App\Models\Interictal;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->Interictal = new Interictal();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {   
        $data = [
            'interictal'=>$this->Interictal->getData(),
        ];
        return view('v_uploadPrediksi',$data);
       
        
    }

    public function uploadFile(Request $request){
        $request->validate([
        'file' => 'required|max:8388608'
        ]);

        $file = new Uploadedf;

        if($request->file()) {
            $name = $request->file->getClientOriginalName();
            $filename = pathinfo($name, PATHINFO_FILENAME);
            $extension = pathinfo($name, PATHINFO_EXTENSION);
           
            $filePath = $request->file('file')->storeAs('uploads', $filename, 'public'); 
        
            
            
            $file->name = pathinfo($name, PATHINFO_FILENAME);
            $file->file = '/storage/' . $filePath;
            $file->save();

            return back()
            ->with('success','File has uploaded to the database.')
            ->with('file', $filename);
            // $data = DB::table('interictal')->get();
            // if()

            // echo $data;
    
        }
   }

//    public function uploadFile(Request $request){
//     $request->validate([
//     'file' => 'required|max:8388608'
//     ]);

//     $file = new Uploadedf;

//     if($request->file()) {
//         $name = $request->file->getClientOriginalName();
//         $filePath = $request->file('file')->storeAs('uploads', $name, 'public');

//         $file->name = $request->file->getClientOriginalName();
//         $file->file = '/storage/' . $filePath;
//         $file->save();

//         return back()
//         ->with('success','File has uploaded to the database.')
//         ->with('file', $name);
//     }
// }

    public function temp()
    {
        return view('dashboardtemp');
    }
}
