<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Interictal extends Model
{
    // public function getData(){
    //     return DB::table('interictal')->get();
    // }
    public function getData(){

        return DB::table('interictal')
        ->join('uploadedfs', 'uploadedfs.name', '=', 'interictal.file_id')
        ->orderBy('interictal.id', 'ASC')->take(1)->get();

        // return \DB::table('uploadedfs')
        // ->join('interictal', 'uploadedfs.name', '=', 'interictal.file_id')
        // ->select('uploadedfs.name')
        // ->take(1)->get();
    }
}
