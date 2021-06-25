@extends('layouts.app', ['activePage' => 'sinyal', 'titlePage' => __('Dashboard'), 'pageName' => 'Data Sinyal'])

@section('content')
<div class="row">
    <div class="container">
    <h2 class="text-center my-5">Sinyal {{$kategori}} {{$namaFile}}</h2>
        <div class="col-lg-10 mx-auto my-5">
            <div class="card card-chart">
                <div class="card-body">
                    <img src="{{ url('storage/'.$sinyal) }}" alt="" style="width: 500px; height: 500px;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
