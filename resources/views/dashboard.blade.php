@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
 <style>
 p{ 
   display:none;
  }

  #formFile::before {
  
  position: absolute;
  z-index: 3;
  display: block;
  background-color: #eee;
  width: 10px;
}
  </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="content">
  <div class="container-fluid">
    <div class="row">
    <div class="row">
        <div class="col-lg-12 col-md-12">
          <div class="card">
            <div class="card-header card-header-tabs card-header-primary">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <span class="nav-tabs-title">Upload File eeg</span>

                  <ul class="nav nav-tabs" data-tabs="tabs">
                    
                   
                    <li class="nav-item">
                      <a class="nav-link" href="#settings" data-toggle="tab">
                        <!-- <i class="material-icons">cloud</i> Server -->
                        <div class="ripple-container"></div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="card-body">
              <div class="tab-content">
                <div class="tab-pane active" id="profile">
                  <table class="table">
                    <tbody>
                      <tr>
                        <td>
                          <div class="form-check">
                          </div>
                        </td>
                        
                        <div>
        <form action="{{route('upload-file')}}" method="post" enctype="multipart/form-data">
            @csrf
           

          @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
          @endif
         

          <div class="container min-vh-100 py-2">
            <div class="row">
                <div class="col">
                    <div class="mb-1">
                        <input class="form-control" type="file" id="formFile" name="file">
                    </div>
                </div>
            </div>
        </div>
            <button type="submit" name="submit" class="btn btn-primary mt-4">
                Upload Files
            </button>
        </form>
        </div>

                      </tr>
                      <tr>
                       
                       
                       <td>
                       @if ($msg = Session::get('success'))
                      <div class = "panel1">
                          <button class="btn btn-primary mt-4">Prediksi</button>
                          
                          @foreach($interictal as $data)
                          
                            <p> File_id : {{ $data->file_id}} </p>
                            <p> Start :{{ $data->start}}</p>
                            <p> End :{{ $data->end}}</p>
                            <p> Longtime: {{ $data->longtime}}</p>
                          
                          @endforeach
                          
                          
                      </div>
             
                     
                      @endif
                    
                      
                        
                         
                        </td>
                      </tr>
                      <tr>
                        
                        
                        
                      </tr>
                    
                    </tbody>
                  </table>
                </div>
               </div>
              </div>
             </div> 


  <script>
    $(document).ready(function(){
    $(".panel2 button").prop('disabled', true);
		$("button").click(function(){
    	$(this).siblings("p").toggle();
      if($(this).parent().prop("className")=='panel1'){
      $(".panel2 button").prop('disabled', false);
      }
    });
});
 </script>  
@endsection

<!-- @push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush -->
