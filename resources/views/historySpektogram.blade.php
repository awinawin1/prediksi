@extends('layouts.app', ['activePage' => 'spektogramHistory', 'titlePage' => __('Dashboard'), 'pageName' => 'Spektogram'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">History Spektogram</h2>
        <div class="col-lg-8 mx-auto my-5">
            Sinyal Spektogram Yang Tersedia :
            @foreach($spektogram as $key=> $data)
            <ul>
                <li><a href="{{route('h_spektogram',$data->filename)}}">{{$data->filename}}</a></li>
            </ul>
            @endforeach
        </div>
    </div>
</div>
@endsection