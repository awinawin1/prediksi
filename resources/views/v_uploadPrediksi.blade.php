@extends('layouts.app', ['activePage' => 'prediksiUpload', 'titlePage' => __('Prediksi'), 'pageName' => 'Prediksi'])

@section('content')
<div class="row">
		<div class="container">
			<h2 class="text-center my-5">Upload Prediksi</h2>
			<h3 class="text-center mu-1" style="color:red;">{{$message}}</h3>
			<div class="card">
				<div class="card-body">
					<div class="col-lg-8 mx-auto my-5">
					<h4>Untuk melakukan prediksi, unggah file sinyal EEG yang memiliki format edf.</h4>
						<form action="{{route('uploadFilePrediksi')}}" method="POST" enctype="multipart/form-data">
							{{ csrf_field() }}

							<div class="form-group">
								<b>File Gambar</b><br/>
							</div>
								<input class="form-control" type="file" id="formFile" name="file">

							<input type="submit" value="Upload" class="btn btn-warning">
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

<!-- @push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush -->
