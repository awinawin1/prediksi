@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])
@section('content')
 <style>
#formFile::before {
  
  position: absolute;
  z-index: 3;
  display: block;
  background-color: #eee;
  width: 10px;
}

p{
  display:none;
  }

  </style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="content">
  <div class="container-fluid">
    <div class="row">
    <div class="row">
        <div class="col-lg-15 col-md-12">
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

            <div class = "panel1"><button type="submit" name="submit" class="btn btn-primary mt-4">
                Upload Files
            </button> </div>
        
            </form>
        </div>

                      
        <tr>
                    
          <td>
          @if ($msg = Session::get('success'))
          <div class = "new">
                <button class="btn btn-primary mt-4">Prediksi</button>
            </div>
          @endif
          </td>
          
        </tr>
        
                    </tbody>
                  </table>
                </div>

                <div class = "panel1">
                <button>button1</button>
                <p>Button 1 triggered</p>
              </div>
              <div class = "panel2">
                <button>button1</button>
                <p>Button 2 triggered</p>
              </div>
             

               </div>
              </div>
             </div> 

            

@endsection

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


// @push('js')
//   <script>
//     $(document).ready(function() {
//       // Javascript method's body can be found in assets/js/demos.js
//       md.initDashboardPageCharts();
//     });
  
@endpush
