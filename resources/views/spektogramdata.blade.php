@extends('layouts.app', ['activePage' => 'spektogramData', 'titlePage' => __('Dashboard'), 'pageName' => 'spektogram'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">Data Spektogram</h2>
        <div class="col-lg-8 mx-auto my-5">
            <div class="row">
                <div class="card">
                    <div class="card-body pb-5">
                        <h3 class="card-title text-center">Biodata Pasien</h3>
                        <p>Sinyal {{$namaFile}} merupakan pasien pediatrik. Data ini berasal dari data di Rumah Sakit Anak Boston. Data berupa rekaman EEG dengan kejang yang tak terobati. Data berasal dari CHB-MIT Scalp EEG. </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 my-1">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">View Data</h3>
                            <div class="row">
                                <div class="col">
                                    <b>Melihat Gambar Mentah Sinyal {{$namaFile}}</b>
                                </div>
                                <div class="col">
                                    <a class="text-center" href="{{route('viewDataSpektogram',$namaFile)}}"><button class="btn btn-warning">Lihat Sinyal</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 my-1">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center">Spektogram Data</h3>
                            <div class="row">
                                <div class="col">
                                    <b>Melakukan Spektogram Terhadap Sinyal {{$namaFile}}</b>
                                </div>
                                <div class="col">
                                    <a class="text-center" href="{{route('spektogram',$namaFile)}}"><button class="btn btn-warning">Spektogram</button></a>
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