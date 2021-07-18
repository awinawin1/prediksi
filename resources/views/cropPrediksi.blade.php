@extends('layouts.app', ['activePage' => 'uploadPrediksi', 'titlePage' => __('Dashboard'), 'pageName' => 'Prediksi'])

@section('content')
  
<div class="row">
    <div class="container">
      <div class="container-fluid">
        <br>
        <h2 class="text-center my-5">Data Prediksi</h2>
        <div class="col-md-auto mx-auto my-5">
          <div class="card card-chart" style="overflow-y:scroll">
            <div class="card-body" style="padding-left:30px;">
              <p>Prediksi dilakukan untuk bersiap sebelum pasien mengalami kejang epilepsi. Kondisi normal adalah kondisi disaat gelombang otak normal. Inter adalah kondisi otak sebelum terjadinya epilepsi. Dan ictal adalah kondisi yang menandakan pasien sedang mengalami kejang.
              Untuk melihat lebih detail dapat melakukan zoom ke titik yang ingin dilihat dengan menarik bar kecil dibawah grafik.</p>
              <h5><b>Kejang akan terjadi {{$waktu_prediksi}} detik setelah segmen {{$index_prediksi}}.</b></h5>
              <div style="width: 750px;" id="myChart"></div>
              <p class="mt-4">Dibawah ini merupakan kondisi kejang pada hasil perekaman EEG dengan gambar berlatar merah merupakan kondisi kejang.</p>
              <img src="{{ asset('stiwarih') }}/chb12.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
<script src="https://cdn.zingchart.com/zingchart.min.js"></script>
<script>
    let myConfig = {
      type: 'line',
      preview: {

      },
      title: {
        text: 'Grafik Sinyal',
        fontSize: 24,
      },
      legend: {
        draggable: true,
      },
      scaleX: {
        // Set scale label
        zooming: true,
        label: { text: ' ' },
        // Convert text on scale indices
      },
      scaleY: {
        // Scale label with unicode character
        label: { text: 'Kondisi Pasien' },
        values : [" ","Normal","Inter","Ictal"]
      },
      plot: {
          aspect : 'spline',
      },
      series: [
        {
          // Plot 1 values, linear data
          values: {!! json_encode($arrayPrediksi) !!},
          text: 'Sinyal EEG',
        }
      ]
    };

    // Render Method[3]
    zingchart.render({
      id: 'myChart',
      data: myConfig,
    });
  </script>

<script src="/assets/moment.js"></script>
<script src="/assets/utils.js"></script>
<link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
<link href="../assets/demo/demo.css" rel="stylesheet" />
<script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script>
<script src="../assets/demo/demo.js"></script>

<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
<link rel="stylesheet" type="text/css" href="/assets/css/berita.css">
@endsection