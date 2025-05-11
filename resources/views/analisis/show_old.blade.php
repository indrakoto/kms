<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>KMS - MIGAS</title>
  <meta name="description" content="">
  <meta name="keywords" content="">

  <!-- Favicons -->
  <link href="{{ asset('img/logo-esdm.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="/" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <img src="{{ asset('img/KMS-by-DIRJEN-MIGAS-02-1.png') }}" />
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="/home">Beranda<br></a></li>
          <li><a href="/analisis" class="active">Analisis</a></li>
          <li><a href="/knowledge">Knowledge</a></li>
          <li><a href="/geoportal">Geo-Portal</a></li>
          <li><a href="/chatbot" class="logo me-auto"><img src="{{ asset('img/LogoAlphaByteBlack.png') }}" /> AI</a></li>
          <li><a class="" href="/administrator"> <i class="bi bi-file-lock2-fill text-warning"  style="font-size:xx-large;"></i> </a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    

    </div>
  </header>

    <main class="main">

      <!-- Courses Section -->
        <section id="courses" class="courses section">

        <div class="container">

            <div class="row">
                <div class="col-lg-3">
                <div class="list-group">

                @foreach ($analisis as $analis)
                    <a 
                        href="{{ route('analisis.index', ['id' => $analis->id]) }}" 
                        class="list-group-item menu-item list-group-item-action {{ $neraca->analisis_id == $analis->id ? 'active-analisis' : '' }}"
                    >
                        {{ $analis->name }}
                    </a>
                @endforeach

                </div>
     
                </div>
                <div class="col-lg-9">
                <div class="row">

                            <h1>{{ $neraca->name }}</h1>
                            <p>{!! $neraca->description !!}</p>

                </div>

                </div>
            </div>

        </div>

        </section><!-- /Courses Section -->
    </main>

<footer id="footer" class="footer position-relative light-background">

  <div class="container footer-top">
    <div class="row gy-4">

    <!-- <iframe src="https://geoportal.esdm.go.id/migas/" width="100%" height="600px;"></iframe> -->

    </div>
  </div>

  <div class="container copyright text-center mt-4">
    <p></p>
    <div class="credits">

    </div>
  </div>

</footer>

<!-- Scroll Top -->
<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Preloader -->
<div id="preloader"></div>

<!-- Vendor JS Files -->
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
<script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

<!-- Main JS File -->
<script src="{{ asset('assets/js/main.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>

</body>

</html>
</body>
</html>
