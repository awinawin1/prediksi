<div style="background-color:#ffecd6;" class="sidebar" data-color="orange">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="{{route('home')}}" class="simple-text logo-normal">
      <img src="{{ asset('material') }}/img/brains.png" style="width:64px" alt="">
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'simulasiEpilepsi' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('simulasiEpilepsi') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <li  class="nav-item {{ ($activePage == 'prediksiUpload' || $activePage == 'uploadKlasifikasi' || $activePage == 'uploadSpektogram' ) ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#simulasi" aria-expanded="false">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Simulasi') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse"  id="simulasi">
          <ul class="nav">
          <!-- Dropdown Prediksi -->
            <li class="nav-item {{ ($activePage == 'prediksiUpload' || $activePage == 'prediksiHistory') ? ' active' : '' }}">
              <a class="nav-link" data-toggle="collapse" href="#prediksiDropdown" aria-expanded="false">
                <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                <p>{{ __('Prediksi') }}
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="prediksiDropdown">
                <ul class="nav">
                  <li class="nav-item{{ $activePage == 'prediksiUpload' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('prediksiUpload') }}">
                      <span class="sidebar-mini"> UP </span>
                      <span class="sidebar-normal">{{ __('Upload File Prediksi') }} </span>
                    </a>
                  </li>
                  <li class="nav-item{{ $activePage == 'prediksiHistory' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('historyPrediksi') }}">
                      <span class="sidebar-mini"> UM </span>
                      <span class="sidebar-normal"> {{ __('History') }} </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
          <!-- Dropdown klasifikasi -->
          <ul class="nav">  
            <li class="nav-item {{ ($activePage == 'uploadKlasifikasi' || $activePage == 'klasifikasiHistory') ? ' active' : '' }}">
              <a class="nav-link" data-toggle="collapse" href="#klasifikasiDropdown" aria-expanded="false" id="simulasi">
                <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                <p>{{ __('Klasifikasi') }}
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="klasifikasiDropdown">
                <ul class="nav">
                  <li class="nav-item{{ $activePage == 'uploadKlasifikasi' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('uploadKlasifikasi') }}">
                      <span class="sidebar-mini"> UP </span>
                      <span class="sidebar-normal">{{ __('Upload File Klasifikasi') }} </span>
                    </a>
                  </li>
                  <li class="nav-item{{ $activePage == 'klasifikasiHistory' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('historyKlasifikasi') }}">
                      <span class="sidebar-mini"> UM </span>
                      <span class="sidebar-normal"> {{ __('History') }} </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
          <!-- Dropdown Spektogram -->
          <ul class="nav">
            <li class="nav-item {{ ($activePage == 'uploadSpektogram' || $activePage == 'spektogramHistory') ? ' active' : '' }}">
              <a class="nav-link" data-toggle="collapse" href="#spektogramDropdown" aria-expanded="false" id="simulasi">
                <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
                <p>{{ __('Spektogram') }}
                  <b class="caret"></b>
                </p>
              </a>
              <div class="collapse" id="spektogramDropdown">
                <ul class="nav">
                  <li class="nav-item{{ $activePage == 'uploadSpektogram' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('uploadSpektogram') }}">
                      <span class="sidebar-mini"> UP </span>
                      <span class="sidebar-normal">{{ __('Upload File Spektogram') }} </span>
                    </a>
                  </li>
                  <li class="nav-item{{ $activePage == 'spektogramHistory' ? ' active' : '' }}">
                    <a class="nav-link" href="{{ route('historySpektogram') }}">
                      <span class="sidebar-mini"> UM </span>
                      <span class="sidebar-normal"> {{ __('History') }} </span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
