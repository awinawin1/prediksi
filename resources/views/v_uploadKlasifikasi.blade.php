@extends('layouts.app', ['activePage' => 'uploadKlasifikasi', 'titlePage' => __('Dashboard'), 'pageName' => 'Klasifikasi'])

@section('content')
	<div class="row">
		<div class="container">
			<h2 class="text-center my-5">Upload File Sinyal EEG</h2>
			<div class="col-lg-8 mx-auto my-5">
			<form action="/upload" method="POST" enctype="multipart/form-data">
					{{ csrf_field() }}

					<div class="form-group">
						<b>File Sinyal EEG</b><br/>
					</div>
						<input class="form-control" type="file" id="formFile" name="file">

					<input type="submit" value="Upload" class="btn btn-primary">
				</form>
			</div>
		</div>
	</div>
@endsection
