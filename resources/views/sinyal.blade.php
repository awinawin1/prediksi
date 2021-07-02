@extends('layouts.app', ['activePage' => 'sinyal', 'titlePage' => __('Dashboard'), 'pageName' => 'Data Sinyal'])

@section('content')
<div class="row">
    <div class="container">
    <h2 class="text-center my-5">Sinyal EEG {{$namaFile}}</h2>
        <div class="col-lg-10 mx-auto my-5">
            <div class="card card-chart">
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-lg-8">
                            <p class="text-justify"><b>Sinyal EEG adalah sinyal yang memberikan informasi fungsi otak dan syaraf. Sinyal EEG mempunyai amplitudo yang rendah, non stasioner dan tidak ada pola tertentu sehingga tidak mudah untuk dianalisis secara visual. Untuk melihat hasil {{$kategori}} terhadap kejang dari sinyal dibawah dapat diklik tombol disamping.</b></p>
                        </div>
                        <div class="col-lg-4 mt-5 d-flex justify-content-center">
                            <a href="{{route($kategori,$namaFile)}}"><button class="btn btn-warning">{{$kategori}}</button></a>
                        </div>
                    </div>
                    <img src="{{ url('storage/'.$sinyal) }}" alt="" style="width: 500px; height: 500px;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
