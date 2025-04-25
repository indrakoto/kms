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

    <!-- Hero Section -->
    <section>

      <div class="container">
                <div id="carouselExampleIndicators" class="carousel slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                        <img src="{{ asset('img/mask-group.png') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="{{ asset('img/mask-group.png') }}" class="d-block w-100" alt="...">
                        </div>
                        <div class="carousel-item">
                        <img src="{{ asset('img/mask-group.png') }}" class="d-block w-100" alt="...">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-6 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
            <img src="img/KMS-Logo-Black.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 order-2 order-lg-1 content" data-aos="fade-up" data-aos-delay="200">
            <h3>Apa itu KMS</h3>
            <p class="fst-italic">
                <p>Knowledge Management System (KMS) Ditjen Migas adalah platform digital yang dirancang untuk mengelola, mendokumentasikan, dan menganalisis berbagai data serta informasi strategis di sektor minyak dan gas bumi.</p>
                <p>KMS ini berfungsi sebagai pusat pengetahuan terintegrasi yang mencakup regulasi, operasional, keuangan, teknologi, serta analisis industri migas. Dengan fitur berbasis AI dan data analytics, sistem ini mendukung pengambilan keputusan, efisiensi operasional, serta pengembangan inovasi dalam pengelolaan migas di Indonesia. </p>
            </p>

          </div>

        </div>

      </div>

    </section><!-- /About Section -->


<section id="analisis-cards" class="analisis-cards section dongker-background">
  
  <div class="container aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
    <h2 style="text-align:center">Analisis</h2>
    <div class="analisis-slider swiper init-swiper swiper-initialized swiper-horizontal swiper-backface-hidden">
      <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "autoplay": {
            "delay": 5000,
            "disableOnInteraction": false
          },
          "grabCursor": true,
          "speed": 600,
          "slidesPerView": "auto",
          "spaceBetween": 20,
          "navigation": {
            "nextEl": ".swiper-button-next",
            "prevEl": ".swiper-button-prev"
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "spaceBetween": 15
            },
            "576": {
              "slidesPerView": 3,
              "spaceBetween": 15
            },
            "768": {
              "slidesPerView": 4,
              "spaceBetween": 20
            },
            "992": {
              "slidesPerView": 5,
              "spaceBetween": 20
            },
            "1200": {
              "slidesPerView": 6,
              "spaceBetween": 20
            }
          }
        }
      </script>

      <div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(-438.667px, 0px, 0px); cursor: grab; transition-delay: 0ms;" id="swiper-wrapper-cba1f6391463fe04" aria-live="off">
        <!-- Analisis Card 1 -->
        

        <!-- Analisis Card 2 -->
        

        <!-- Analisis Card 3 -->
        

        <!-- Analisis Card 4 -->
        

        <!-- Analisis Card 5 -->
        

        <!-- Analisis Card 6 -->
        

        <!-- Analisis Card 7 -->
        

        <!-- Analisis Card 8 -->
        
        <div class="swiper-slide" style="width: 199.333px; margin-right: 20px;" role="group" aria-label="6 / 8" data-swiper-slide-index="1">
          <div class="analisis-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="400">
            <div class="analisis-image">
              <img src="{{ asset('img/neraca-arus-minyak-bumi.png') }}" alt="Analisis" class="img-fluid">
            </div>
            <h3 class="analisis-title">Neraca Arus Minyak Bumi</h3>
          </div>
        </div>
        <div class="swiper-slide swiper-slide-prev" style="width: 199.333px; margin-right: 20px;" role="group" aria-label="7 / 8" data-swiper-slide-index="2">
          <div class="analisis-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="500">
            <div class="analisis-image">
              <img src="{{ asset('img/neraca-arus-lpg.png') }}" alt="Analisis" class="img-fluid">
            </div>
            <h3 class="analisis-title">Neraca Arus LPG</h3>
          </div>
        </div>
        <div class="swiper-slide swiper-slide-active" style="width: 199.333px; margin-right: 20px;" role="group" aria-label="8 / 8" data-swiper-slide-index="3">
          <div class="analisis-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="600">
            <div class="analisis-image">
              <img src="{{ asset('img/neraca-arus-gas.png') }}" alt="Analisis" class="img-fluid">
            </div>
            <h3 class="analisis-title">Neraca Arus Gas</h3>
          </div>
        </div>
        <div class="swiper-slide swiper-slide-next" style="width: 199.333px; margin-right: 20px;" role="group" aria-label="1 / 8" data-swiper-slide-index="4">
          <div class="analisis-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="700">
            <div class="analisis-image">
              <img src="{{ asset('img/capaian-kinerja-sicaki.png') }}" alt="Analisis" class="img-fluid">
            </div>
            <h3 class="analisis-title">Capaian Kinerja (SICAKI)</h3>
          </div>
        </div>
        <div class="swiper-slide" style="width: 199.333px; margin-right: 20px;" role="group" aria-label="2 / 8" data-swiper-slide-index="5">
          <div class="analisis-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="800">
            <div class="analisis-image">
              <img src="{{ asset('img/esakip.png') }}" alt="Analisis" class="img-fluid">
            </div>
            <h3 class="analisis-title">E-SAKIP</h3>
          </div>
        </div>
        <div class="swiper-slide" style="width: 199.333px; margin-right: 20px;" role="group" aria-label="3 / 8" data-swiper-slide-index="6">
          <div class="analisis-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="100">
            <div class="analisis-image">
              <img src="{{ asset('img/gear.png') }}" alt="Analisis" class="img-fluid">
            </div>
            <h3 class="analisis-title">Manajemen Resiko</h3>
            <p class="analisis-count">(Aplikasi Kementerian)</p>
            <a href="ctaegory.html" class="stretched-link"></a>
          </div>
        </div>
        <div class="swiper-slide" style="width: 199.333px; margin-right: 20px;" role="group" aria-label="4 / 8" data-swiper-slide-index="7">
          <div class="analisis-card aos-init aos-animate" data-aos="fade-up" data-aos-delay="200">
            <div class="analisis-image">
              <img src="{{ asset('img/model-proyeksi.png') }}" alt="Analisis" class="img-fluid">
            </div>
            <h3 class="analisis-title">Model Proyeksi</h3>
            <p class="analisis-count">&nbsp;</p>
            <a href="ctaegory.html" class="stretched-link"></a>
          </div>
        </div>

      </div>

      <div class="swiper-button-next" tabindex="0" role="button" aria-label="Next slide" aria-controls="swiper-wrapper-cba1f6391463fe04"></div>
      <div class="swiper-button-prev" tabindex="0" role="button" aria-label="Previous slide" aria-controls="swiper-wrapper-cba1f6391463fe04"></div>
    <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span><span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span></div>

  </div>

</section>

    <!-- Courses Section -->
    <section id="courses" class="courses section">
      <!-- Section Title -->

        


      <div class="container">
        <div class="row">
        <h3 class="text-center mb-4">Knowledge Terbaru</h3>
        @foreach ($latestArticles as $article)
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="course-item">
              
              <div class="course-content">
              <img src="{{ asset('img/rectangle-17.png') }}" class="img-fluid mb-4" alt="...">
                <div class="d-flex justify-content-between align-items-center">
                @if($article->source->name == 'YOUTUBE')
                  <p><button class="btn btn-sm btn-danger"><i class="bi bi-youtube"></i> &nbsp; {{ $article->category->name }}</button></p>
                @elseif($article->source->name == 'MP4')
                  <p><button class="btn btn-sm btn-warning"><i class="bi bi-play-circle-fill"></i> &nbsp; {{ $article->category->name }}</button></p>
                @elseif($article->source->name == 'OGG')
                  <p><button class="btn btn-sm btn-success"><i class="bi bi-play-circle-fill"></i> &nbsp; {{ $article->category->name }}</button></p>
                @elseif($article->source->name == 'PDF')
                  <p><button class="btn btn-sm btn-success text-light" ><i class="bi bi-file-pdf" style=""></i> &nbsp; {{ $article->category->name }}</button></p>
                @else 

                @endif
                </div>

                <h3><a href="{{ route('article.show', $article->id) }}">{{ $article->title }}</a></h3>
                <p class="description"> Institusi:  </p>
                <div class="trainer d-flex justify-content-between align-items-center">
                  <div class="trainer-profile d-flex align-items-center">
                    <img src="assets/img/trainers/trainer-1-2.jpg" class="img-fluid" alt="">
                    <a href="" class="trainer-link">{{ $article->user->name }}</a>
                  </div>
                  <div class="trainer-rank d-flex align-items-center">
                    <i class="bi bi-person user-icon"></i>&nbsp;50
                    &nbsp;&nbsp;
                    <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;65
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- End Course Item-->
          @endforeach

          <div class="mt-4 text-center"><a href="/knowledge" class="read-more"><span>Lihat Selengkapnya</span><i class="bi bi-arrow-right"></i></a></div>
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