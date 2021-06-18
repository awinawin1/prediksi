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
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
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

// Klasifikasi
Route::get('/uploadKlasifikasi',  [KlasifikasiController::class, 'index'])->name('uploadKlasifikasi');
Route::post('/upload', [KlasifikasiController::class, 'upload'])->name('upload');
Route::get('/view-data/{namaFile}', [KlasifikasiController::class, 'viewData'])->name('viewData');
Route::get('/klasifikasi/{namaFile}', [KlasifikasiController::class, 'klasifikasi'])->name('klasifikasi');

// Spektogram
Route::get('/uploadSpektogram',  [SpektogramController::class, 'index'])->name('uploadSpektogram')->middleware('auth');
Route::post('/uploadFileSpektogram', [SpektogramController::class, 'upload'])->name('uploadFileSpektogram');
Route::get('/view-dataSpektogram/{namaFile}', [SpektogramController::class, 'viewData'])->name('viewDataSpektogram');
Route::get('/spektogram/{namaFile}', [SpektogramController::class, 'spektogram'])->name('spektogram');

Route::group(['middleware' => 'auth'], function () {
	Route::get('table-list', function () {
		return view('pages.table_list');
	})->name('table');

	Route::get('typography', function () {
		return view('pages.typography');
	})->name('typography');

	Route::get('icons', function () {
		return view('pages.icons');
	})->name('icons');

	Route::get('map', function () {
		return view('pages.map');
	})->name('map');

	Route::get('notifications', function () {
		return view('pages.notifications');
	})->name('notifications');

	Route::get('rtl-support', function () {
		return view('pages.language');
	})->name('language');

	Route::get('upgrade', function () {
		return view('pages.upgrade');
	})->name('upgrade');
});

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
});

