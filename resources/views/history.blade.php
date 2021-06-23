@extends('layouts.app', ['activePage' => 'history', 'titlePage' => __('Dashboard'), 'pageName' => 'History'])

@section('content')

<div class="row">
    <div class="container">
      <div class="container-fluid">
        <br>
        <h2 class="text-center my-5">Sinyal {{$namaFile}}</h2>
        <div class="col-md-auto mx-auto my-5">
          <div class="card card-chart" style="width: 800px; overflow-y:scroll">
            <div class="card-body">
              <div style="width: 750px;" id="myChart"></div>
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
        text: ' ',
        fontSize: 24,
      },
      legend: {
        draggable: true,
      },
      scaleX: {
        // Set scale label
        zooming:true,
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
          values: {!! json_encode($output) !!},
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