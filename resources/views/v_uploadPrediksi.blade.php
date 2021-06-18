@extends('layouts.app', ['activePage' => 'prediksiUpload', 'titlePage' => __('Prediksi'), 'pageName' => 'Prediksi'])

@section('content')
<div class="row">
		<div class="container">
			<h2 class="text-center my-5">Membuat Upload File Dengan Laravel</h2>
			<div class="col-lg-8 mx-auto my-5">
			<form action="{{route('uploadFilePrediksi')}}" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}

					<div class="form-group">
						<b>File Gambar</b><br/>
					</div>
						<input class="form-control" type="file" id="formFile" name="file">

					<input type="submit" value="Upload" class="btn btn-primary">
				</form>
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
