@extends('layouts.app', ['activePage' => 'prediksiData', 'titlePage' => __('Dashboard'), 'pageName' => 'Prediksi'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">Data Prediksi</h2>
        <div class="col-lg-8 mx-auto my-5">
            <div class="row">
                <div class="card">
                    <div class="card-body pb-5">
                        <h3 class="card-title text-center">Biodata Pasien</h3>
                        <p>Dataset CHB-MIT1, terdiri dari catatan dari 23 pasien; dengan satu kasus (chb21) diambil dari pasien yang sama (chb01) 1,5 tahun kemudian. Kumpulan data dikumpulkan oleh penyelidik di Rumah Sakit Anak Boston dan Massachusetts Institute of Technology (MIT). Panjang rata-rata pengumpulan adalah selama 36 jam dengan celah kecil antara catatan setiap jam karena keterbatasan perangkat keras. 
                        Sinyal {{$namaFile}} merupakan pasien yang memiliki usia {{$age}} tahun dan berjenis kelamin {{$gender}}. Pada proses pencatatan sinyal pasien terdapat {{$seizure}} kejang. Kejang terjadi selama {{$ictal}} detik dan sebelum kejang atau interiktal terjadi selama {{$inter}} detik.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 my-1">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">View Data</h3>
                            <div class="col text-center">
                                <div class="row" style="height:75px;">
                                    <b>Melihat Gambar Mentah Sinyal {{$namaFile}}</b>
                                </div>
                                <div class="row d-flex justify-content-center border-top">
                                    <a href="{{route('viewDataPrediksi',$namaFile)}}"><button class="btn btn-warning">Lihat Sinyal</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 my-1">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Prediksi Data</h3>
                            <div class="col">
                                <div class="row" style="height:75px;">
                                    <b>Melakukan Prediksi Terhadap Sinyal {{$namaFile}}</b>
                                </div>
                                <div class="row d-flex justify-content-center border-top">
                                    <a class="text-center" href="{{route('prediksi',$namaFile)}}"><button class="btn btn-warning">Prediksi</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection