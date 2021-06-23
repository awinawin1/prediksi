@extends('layouts.app', ['activePage' => 'klasifikasiData', 'titlePage' => __('Dashboard'), 'pageName' => 'Klasifikasi'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">Data Klasifikasi</h2>
        <div class="col-lg-8 mx-auto my-5">
            <b>View Data</b><br>
            <a href="{{route('viewData',$namaFile)}}">{{$namaFile}}</a><br>
            <b>Klasifikasi Data</b><br>
            <a href="{{route('klasifikasi',$namaFile)}}">{{$namaFile}}</a><br>
        </div>
    </div>
</div>
@endsection