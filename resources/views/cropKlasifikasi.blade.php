@extends('layouts.app', ['activePage' => 'uploadKlasifikasi', 'titlePage' => __('Dashboard'), 'pageName' => 'Klasifikasi'])

@section('content')
<style>
  #chartWrapper{
    position : relative;
    overflow-x:scroll;
    overflow-y:scroll;
    height:300px;
  }
  #chartWrapper > canvas{
    position : absolute;
    left : 0;
    top : 0;
  }
  #chartAreaWrapper{
    width:70000px;
  }
  canvas{
    width:70000px;
  }
</style>
<div class="row">
    <div class="container">
      <div class="container-fluid">
        <br>
        <h2 class="text-center my-5">Data Klasifikasi</h2>
        <div class="col-md-auto mx-auto my-5">
          <div class="card card-chart" id="chartWrapper">
              <div class="card-body" id="chartAreaWrapper">
                <canvas height="250px" id="chart1"></canvas>
                <br>
                <br>
              </div>
          </div>
        </div>
      </div>
    </div>
</div>
<script>
  window.onload=function(){/*from  w w w . j  av a  2s.c  o m*/
    var yLabels = {
      1 : 'Normal',
      2 : 'Inter',
      3 : 'Ictal'
    }
    var ctx = document.getElementById("chart1");
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: {!! json_encode($segmen) !!},
        datasets: [{
          data: {!! json_encode($arrayKlasifikasi) !!},
          backgroundColor: [
            'rgba(255, 159, 64, 0)'
          ],
          borderColor: [
            'rgba(255,99,132,1)'
          ],
          borderWidth: 1
        }]
      },
      options: {
        responsive: false,
        maintainAspectRatio: false,
        legend: {
          display: false
        },
        scales: {
          xAxes: [{
            ticks: {
              beginAtZero: true,
              autoSkip : false
            }
          }],
          yAxes: [{
            ticks: {
              beginAtZero: true,
              callback: function(value, index, values) {
                  return yLabels[value];
              }
            }
          }]
        },
        title: {
          display: true,
          text: 'Klasifikasi'
        }
      }
    });
  }
</script>
<script src="/assets/moment.js"></script>
<script src="/assets/Chart.min.js"></script>
<script src="/assets/utils.js"></script>
<link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
<!-- CSS Files -->
<!-- CSS Just for demo purpose, don't include it in your project -->
{{-- <link href="../assets/demo/demo.css" rel="stylesheet" /> --}}
  <!--   Core JS Files   -->
<script src="../assets/js/core/jquery.min.js"></script>
<script src="../assets/js/core/popper.min.js"></script>
<script src="../assets/js/core/bootstrap.min.js"></script>
<script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
<!--  Google Maps Plugin    -->
<!-- Place this tag in your head or just before your close body tag. -->
<script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Chart JS -->
<!--  Notifications Plugin    -->
<script src="../assets/js/plugins/bootstrap-notify.js"></script>
<!-- Control Center for Black Dashboard: parallax effects, scripts for the example pages etc -->
<script src="../assets/js/black-dashboard.min.js?v=1.0.0"></script><!-- Black Dashboard DEMO methods, don't include it in your project! -->
<script src="../assets/demo/demo.js"></script>

<link rel="stylesheet" type="text/css" href="/assets/css/main.css">
<link rel="stylesheet" type="text/css" href="/assets/css/berita.css">
@endsection