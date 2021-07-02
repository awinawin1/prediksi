@extends('layouts.app', ['activePage' => 'simulasiEpilepsi', 'titlePage' => __('Dashboard'),'pageName'=>'Beranda Simulasi'])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <h2 class="text-center">Simulasi Epilepsi</h2>
      <div class="row">
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header">
              <img class="d-flex justify-content-center" style="width:50px" src="{{ asset('material') }}/img/laravel.svg" alt="">
            </div>
            <div class="card-body">
              <h4 class="card-title">Klasifikasi</h4>
              <p class="card-category d-flex justify-content-center" style="height:100px;">
                Mengklasifikasikan sinyal menjadi tiga yaitu kondisi normal, kondisi inter, dan kondisi ictal(kejang) yang membutuhkan inputan file sinyal EEG. 
              </p>
              <div class="border-top text-center">
                <a class="text-white" href="{{route('uploadKlasifikasi')}}">
                  <button class="btn btn-warning">Simulasi Klasifikasi</button>
                </a>  
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header">
              <img class="text-center" style="width:50px" src="{{ asset('material') }}/img/laravel.svg" alt="">
            </div>
            <div class="card-body">
              <h4 class="card-title">Prediksi</h4>
              <p class="card-category d-flex justify-content-center" style="height:100px;">
                Melakukan prediksi terhadap sinyal EEG yang diinputkan sehingga menghasilkan waktu prediksi akan terjadi kejang epilepsi.
              </p>
              <div class="border-top text-center">
                <a class="text-white" href="{{route('prediksiUpload')}}">
                  <button class="btn btn-warning">Simulasi Prediksi</button>
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card card-chart">
            <div class="card-header">
              <img style="width:50px" src="{{ asset('material') }}/img/laravel.svg" alt="">
            </div>
            <div class="card-body">
              <h4 class="card-title">Spektogram</h4>
              <p class="card-category d-flex justify-content-center" style="height:100px;">
                Melakukan klasifikasi sinyal EEG yang diinputkan dan menghasilkan gambar spektrum dari setiap segmen yang dihasilkan.
              </p>
              <div class="border-top text-center">
                <a class="text-white" href="{{route('uploadSpektogram')}}">
                  <button class="btn btn-warning">Simulasi Spektogram</button>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush