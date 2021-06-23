@extends('layouts.app', ['activePage' => 'prediksiHistory', 'titlePage' => __('Dashboard'), 'pageName' => 'Prediksi'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">History Prediksi</h2>
        <div class="col-lg-8 mx-auto my-5">
            Sinyal Prediksi Yang Tersedia :
            @foreach($prediksi as $key=> $data)
            <ul>
                <li><a href="{{route('h_prediksi',$data->filename)}}">{{$data->filename}}</a></li>
            </ul>
            @endforeach
        </div>
    </div>
</div>
@endsection