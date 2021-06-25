@extends('layouts.app', ['activePage' => 'spektogramImage', 'titlePage' => __('Dashboard'), 'pageName' => 'Spektogram'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">Gambar Spektogram</h2>
        <h3 class="text-center my-5">Sinyal {{$namaFile}} Segmen {{$segmen}}</h3>
        <div class="col-lg-10 mx-auto my-5">
            <div class="card card-chart">
                <div class="card-body">
                    <img src="{{ url('storage/fitur3Kelas30DetikImg/'.$spektogramFile) }}" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
