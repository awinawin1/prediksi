@extends('layouts.app', ['activePage' => 'klasifikasiHistory', 'titlePage' => __('Dashboard'), 'pageName' => 'Klasifikasi'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">History Klasifikasi</h2>
        <div class="col-lg-8 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    Sinyal Klasifikasi Yang Tersedia :
                    @foreach($klasifikasi as $key=> $data)
                    <ul class="list-group">
                        <li class="list-group-item border-bottom"><a href="{{route('h_klasifikasi',$data->filename)}}">{{$data->filename}}</a></li>
                    </ul>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection