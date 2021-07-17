@extends('layouts.app', ['activePage' => 'spekto', 'titlePage' => __('Dashboard'), 'pageName' => 'List Gambar Spektogram'])

@section('content')
<div class="row">
    <div class="container">
        <h2 class="text-center my-5">Gambar Spektogram</h2>
        <div class="col-lg-12 mx-auto my-5">
            <div class="card">
                <div class="card-body">
                    Sinyal Spektogram Yang Tersedia :</br>
                    <!-- <img src="{{ url('storage/fitur3Kelas30DetikImg/chb01_03.edf/chb01_03.edf_0.png') }}" alt=""> -->
                    @for ($i = 0; $i < 250; $i++)
                        Segmen {{$i}}
                        <img src="{{ url('storage/fitur3Kelas30DetikImg/'.$namaFile.'/'.$namaFile.'_'.$i.'.png') }}" alt=""></br>
                    @endfor
                
                </div>
            </div>
        </div>
    </div>
</div>
@endsection