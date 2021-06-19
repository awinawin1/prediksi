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
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {   
        return view('welcome');
    }
    public function simulasi(){
        $user= auth()->user();
        if($user){
            return view('dashboardSimulasi');
        }
        else{
            return view('auth.login');
        }
    }
}
