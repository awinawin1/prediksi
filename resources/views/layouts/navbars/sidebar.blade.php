<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="https://creative-tim.com/" class="simple-text logo-normal">
      {{ __('Prediksi Epilepsi') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'temp' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('temp') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
      <!-- Dropdown Prediksi -->
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#prediksiDropdown" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Prediksi') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="prediksiDropdown">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('home') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('Upload File Prediksi') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('History') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- Dropdown klasifikasi -->
      <li class="nav-item {{ ($activePage == 'form-upload') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#klasifikasiDropdown" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Klasifikasi') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="klasifikasiDropdown">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'uploadKlasifikasi' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('uploadKlasifikasi') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('Upload File Klasifikasi') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('History') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <!-- Dropdown Spektogram -->
      <li class="nav-item {{ ($activePage == 'uploadSpektogram' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#spektogramDropdown" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Spektogram') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="spektogramDropdown">
          <ul class="nav">
            <li class="nav-item{{ $activePage == 'uploadSpektogram' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('uploadSpektogram') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('Upload File Spektogram') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('History') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</div>
