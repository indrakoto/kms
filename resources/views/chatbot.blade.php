<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>KMS - MIGAS</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Favicons -->
  <link href="{{ asset('img/KMS-by-DIRJEN-MIGAS-02-1.png') }}" rel="icon">
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
  <link href="{{ asset('assets/css/chat.css') }}" rel="stylesheet" />

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
          <li><a href="/home" class="active">Beranda<br></a></li>
          <li><a href="/analisis">Analisis</a></li>
          <li><a href="/knowledge">Knowledge</a></li>
          <li><a href="/geoportal">Geo-Portal</a></li>
          <li><a href="/chatbot">Help</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      
        <form action="#" method="post" class="searchx">
            <div class="search-form"><input type="text" name="search"></div>
        </form>

      <a class="btn-getstarted" href="/administrator">Masuk</a>

    </div>
  </header>

  <main class="main">

    <!-- Courses Section -->
    <section id="courses" class="courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Help</h2>
        <p>Chatbot AI</p>
        <div class=" py-4">
          
            <div id="chat-box" class="border rounded p-3 mb-3" style="height: 400px; overflow-y: scroll;">
                <!-- Pesan akan ditampilkan di sini -->
            </div>

            <div class="input-group">
                <input type="text" id="user-input" class="form-control" placeholder="Ketik pesan...">
                <button id="send-btn" class="btn btn-primary">Kirim</button>
            </div>
        </div>
      </div><!-- End Section Title -->

    </section><!-- /Courses Section -->

  </main>

  <footer id="footer" class="footer position-relative dongker-background">

    <div class="container footer-top">
      <div class="row gy-4">

      <!-- <iframe src="https://geoportal.esdm.go.id/migas/" width="100%" height="600px;"></iframe> -->

      </div>
    </div>

    <div class="container copyright text-center mt-4">
      <p></p>
      <div class="credits">
copyright
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
  <script src="{{ asset('assets/js/chat.js') }}"></script>

</body>

</html>