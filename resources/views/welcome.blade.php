<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>{{config('app.name')}}</title>
      <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/brains.png">
      <link rel="icon" type="image/png" href="{{ asset('material') }}/img/brains.png">
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" href="{{ asset('material') }}/css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" href="{{ asset('material') }}/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="{{ asset('material') }}/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="{{ asset('material') }}/img/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
      <style>
         #myBtn {
            display: none;
            position: fixed;
            bottom: 20px;
            right: 30px;
            z-index: 99;
            font-size: 18px;
            border: none;
            outline: none;
            background-color: #f4dde7;
            color: #10103a;
            cursor: pointer;
            padding: 15px;
            border-radius: 100px;
         }

         #myBtn:hover {
            background-color: #10103a;
            color: #f4dde7;
         }
      </style>
   </head>
   <!-- body -->
   <body class="main-layout">
      <button onclick="topFunction()" id="myBtn" title="Go to top">Top</button>
      <!-- loader  -->
      <!-- <div class="loader_bg">
         <div class="loader"><img src="{{ asset('material') }}/img/loading.gif" alt="#" /></div>
      </div> -->
      <!-- end loader -->
      <!-- header -->
      <header>
         <!-- header inner -->
         <div class="header">
            <div class="container">
               <div class="row">
                  <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                     <div class="full">
                        <div class="center-desk">
                           <div class="logo">
                              <a href="{{route('home')}}"><img src="{{ asset('material') }}/img/brains.png" style="width:64px" alt="#" /></a>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                     <nav class="navigation navbar navbar-expand-md navbar-dark">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04">
                           <ul class="navbar-nav mr-auto">
                              <li class="nav-item">
                                 <a class="nav-link" href="#">Home</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#tentang"> Tentang  </a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#Simulasi">Simulasi</a>
                              </li>
                              <li class="nav-item">
                                 <a class="nav-link" href="#simulasikan">Coba Sekarang</a>
                              </li>
                              @if (Auth::check())
                              <li class="nav-item dropdown">
                                 <a class="nav-link" href="#" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Akun
                                 </a>
                                 <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                                    <a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profil') }}</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                          @csrf
                                       </form>
                                       Log Out
                                    </a>
                                 </div>
                              </li>
                              @else
                              <li class="nav-item">
                                 <a class="nav-link" href="{{route('login')}}">Login</a>
                              </li>
                              @endif
                           </ul>
                        </div>
                     </nav>
                  </div>
               </div>
            </div>
         </div>
      </header>
      <!-- end header inner -->
      <!-- end header -->
      <!-- banner -->
      <section class="banner_main">
         <div class="container">
            <div class="row d_flex">
               <div class="col-md-5">
                  <div class="text-bg">
                     <h1>Epilepsi</h1>
                     <p>Berdasarkan data dari <i>World Health Organization(WHO)</i>, diperkirakan lima juta orang didiagnosis dengan epilepsi setiap tahun. Di negara-negara berpenghasilan tinggi, diperkirakan ada 49 per 100.000 orang yang didiagnosis menderita epilepsi setiap tahun. Di negara-negara berpenghasilan rendah dan menengah, angka ini bisa mencapai 139 per 100.000.</p>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="text-img">
                     <figure><img src="{{ asset('material') }}/img/epilepsyBg.jpeg" /></figure>
                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- end banner -->
      <!-- Hosting -->
      <div class="hosting" id="tentang">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Apa Itu Epilepsi ?</h2>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="web_hosting">
                     <figure><img style="height:256px"src="{{ asset('material') }}/img/epilepsyIcon.png" alt="#"/></figure>
                     <p>Epilepsi adalah penyakit otak kronis yang tidak menular yang mempengaruhi sekitar 50 juta orang di seluruh dunia. Hal ini ditandai dengan kejang berulang, yang merupakan gerakan singkat tak sadar yang mungkin melibatkan sebagian tubuh atau seluruh tubuh dan kadang-kadang disertai dengan hilangnya kesadaran dan kontrol fungsi usus atau kandung kemih. Kejang terjadi akibat dari pelepasan listrik yang berlebihan pada sekelompok sel otak. Bagian otak yang berbeda dapat menjadi tempat pembuangan tersebut. Kejang dapat bervariasi dari penyimpangan perhatian atau sentakan otot yang singkat hingga kejang yang parah dan berkepanjangan. Kejang juga dapat bervariasi dalam frekuensi, dari kurang dari 1 per tahun hingga beberapa per hari.<i>(WHO)</i></p>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end Hosting -->
      <!-- Services  -->
      <div id="Simulasi" class="Services">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Simulasi Klasifikasi dan Prediksi Epilepsi</h2>
                     <p>Terdapat tiga fitur yang dapat digunakan untuk melakukan klasifikasi dan prediksi epilepsi
                     </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                  <div class="Services-box">
                     <i><img src="{{ asset('material') }}/img/service1.png" alt="#" /></i>
                     <h3>Klasifikasi Wavelet</h3>
                     <p>Melakukan klasifikasi untuk membedakan kondisi normal, sebelum kejang, dan saat kejang.</p>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                  <div class="Services-box">
                     <i><img src="{{ asset('material') }}/img/service2.png" alt="#" /></i>
                     <h3>Prediksi</h3>
                     <p>Mendapatkan waktu untuk persiapan sebelum kejang terjadi.</p>
                  </div>
               </div>
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                  <div class="Services-box">
                     <i><img src="{{ asset('material') }}/img/service3.png" alt="#" /></i>
                     <h3>Klasifikasi Spektogram</h3>
                     <p>Melakukan klasifikasi dan menampilkan gambar sinyal spektrum.</p>
                  </div>
               </div>
               
               <a class="read_more" href="#simulasikan">Coba Sekarang</a>
            </div>
         </div>
      </div>
      <!-- end Servicess -->
      <!-- why -->
      <div id="simulasikan" class="why">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="titlepage">
                     <h2>Uji Coba Simulasi Epilepsi</h2>
                  </div>
               </div>
            </div>
            <div class="row d-flex justify-content-center">
               <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                  <div class="why-box">
                     <i><img src="{{ asset('material') }}/img/why2.png" alt="#" /></i>
                     <h3>Simulasi Epilepsi</h3>
                     <p>Untuk melakukan uji coba mensimulasikan terjadinya epilepsi</p>
                     <div class="border-top my-3"></div>
                     <a class="read_more bg" href="{{ route('simulasiEpilepsi') }}">Simulasi Epilepsi</a>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- end why -->
      <!-- contact -->

      <!-- end contact -->
      <!--  footer -->
      <footer>
         <div class="footer mt-5 border-top">
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <p>© 2019 All Rights Reserved.</p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- end footer -->
      <!-- Javascript files-->
      <script src="{{ asset('material') }}/js/jquery.min.js"></script>
      <script src="{{ asset('material') }}/js/popper.min.js"></script>
      <script src="{{ asset('material') }}/js/bootstrap.bundle.min.js"></script>
      <script src="{{ asset('material') }}/js/jquery-3.0.0.min.js"></script>
      <script src="{{ asset('material') }}/js/plugin.js"></script>
      <!-- sidebar -->
      <script src="{{ asset('material') }}/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="{{ asset('material') }}/js/custom.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
      <script>
         var mybutton = document.getElementById("myBtn");
         window.onscroll = function() {scrollFunction()};
         function scrollFunction() {
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
               mybutton.style.display = "block";
            } else {
               mybutton.style.display = "none";
            }
         }
         function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
         }
      </script>
   </body>
</html>