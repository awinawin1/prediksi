<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\SpektogramController;
use App\Http\Controllers\PrediksiController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/simulasiEpilepsi',[HomeController::class,'simulasi'])->name('simulasiEpilepsi');
Auth::routes();
Route::post('/uploadfile', [HomeController::class, 'uploadFile'])->name('upload-file');
// Route::get('upload', [HomeController::class, 'uploadFile'])->name('upload-file');

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

Auth::routes();

//Prediksi
Route::get('/prediksiUpload',[PrediksiController::class,'index'])->name('prediksiUpload');
Route::post('/uploadFilePrediksi', [PrediksiController::class, 'upload'])->name('uploadFilePrediksi');
Route::get('/view-dataPrediksi/{namaFile}', [PrediksiController::class, 'viewData'])->name('viewDataPrediksi');
Route::get('/prediksi/{namaFile}', [PrediksiController::class, 'prediksi'])->name('prediksi');
Route::get('/sinyal-prediksi/{namaFile}', [PrediksiController::class, 'history'])->name('h_prediksi');
Route::get('/history_prediksi',function(){
	$prediksi = DB::table('prediksis')->get();
	return view('historyPrediksi',['prediksi'=>$prediksi]);
})->name('historyPrediksi');

// Klasifikasi
Route::get('/uploadKlasifikasi',  [KlasifikasiController::class, 'index'])->name('uploadKlasifikasi');
Route::post('/upload', [KlasifikasiController::class, 'upload'])->name('upload');
Route::get('/view-data/{namaFile}', [KlasifikasiController::class, 'viewData'])->name('viewData');
Route::get('/klasifikasi/{namaFile}', [KlasifikasiController::class, 'klasifikasi'])->name('klasifikasi');
Route::get('/sinyal-klasifikasi/{namaFile}', [KlasifikasiController::class, 'history'])->name('h_klasifikasi');
Route::get('/history_klasifikasi',function(){
	$klasifikasi = DB::table('klasifikasis')->get();
	return view('historyKlasifikasi',['klasifikasi'=>$klasifikasi]);
})->name('historyKlasifikasi');

// Spektogram
Route::get('/uploadSpektogram',  [SpektogramController::class, 'index'])->name('uploadSpektogram')->middleware('auth');
Route::post('/uploadFileSpektogram', [SpektogramController::class, 'upload'])->name('uploadFileSpektogram');
Route::get('/view-dataSpektogram/{namaFile}', [SpektogramController::class, 'viewData'])->name('viewDataSpektogram');
Route::get('/spektogram/{namaFile}', [SpektogramController::class, 'spektogram'])->name('spektogram');
Route::get('/sinyal-spektogram/{namaFile}', [SpektogramController::class, 'history'])->name('h_spektogram');
Route::get('/history_spektogram',function(){
	$spektogram = DB::table('spektograms')->get();
	return view('historySpektogram',['spektogram'=>$spektogram]);
})->name('historySpektogram');
Route::get('/spektogram-picture/{namaFile}/{index}',[SpektogramController::class, 'imageSpektogram']);

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

