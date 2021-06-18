@extends('layouts.app', ['activePage' => 'prediksiData', 'titlePage' => __('Dashboard'), 'pageName' => 'Prediksi'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">Data Prediksi</h2>
        <div class="col-lg-8 mx-auto my-5">
            <b>View Data</b><br>
            <a href="{{route('viewDataPrediksi',$namaFile)}}">{{$namaFile}}</a><br>
            <b>Klasifikasi Data</b><br>
            <a href="{{route('prediksi',$namaFile)}}">{{$namaFile}}</a><br>
        </div>
    </div>
</div>
@endsection