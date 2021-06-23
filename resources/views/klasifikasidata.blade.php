@extends('layouts.app', ['activePage' => 'klasifikasiData', 'titlePage' => __('Dashboard'), 'pageName' => 'Klasifikasi'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">Berhasil Upload File {{$namaFile}}</h2>

        <div class="col-lg-8 mx-auto my-5">

            <div class="row">
                <div class="col-lg-4 mx-auto my-5">
                <a style="margin-left: 150px" class="btn btn-primary" href="{{route('viewData',$namaFile)}}">View Data</a><br>
                </div>
                <div class="col-lg-4 mx-auto my-5">
                <a style="margin-left: -80px" class="btn btn-primary" href="{{route('klasifikasi',$namaFile)}}"">Klasifikasi Data</a><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
