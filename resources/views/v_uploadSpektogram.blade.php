@extends('layouts.app', ['activePage' => 'uploadSpektogram', 'titlePage' => __('Dashboard'), 'pageName' => 'Spektogram'])

@section('content')
	<div class="row">
		<div class="container">
			<h2 class="text-center my-5">Upload Spektogram</h2>
			<h3 class="text-center mu-1" style="color:red;">{{$message}}</h3>
			<div class="card">
				<div class="card-body">
					<div class="col-lg-8 mx-auto my-5">
						<h4>Untuk melakukan prediksi, unggah file sinyal EEG yang memiliki format edf.</h4>
						<form action="{{route('uploadFileSpektogram')}}" method="POST" enctype="multipart/form-data">
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
