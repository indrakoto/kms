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
          <li><a href="/analisis">Analisis</a></li>
          <li><a href="/knowledge" class="active">Knowledge</a></li>
          <li><a href="/geoportal">Geo-Portal</a></li>
          <li><a href="/chatbot" class="logo me-auto"><img src="{{ asset('img/LogoAlphaByteBlack.png') }}" /> AI</a></li>
          <li><a class="" href="/administrator"> <i class="bi bi-file-lock2-fill text-warning"  style="font-size:xx-large;"></i> </a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>


    </div>
  </header>

    <main class="main">
    <!-- Page Title -->
      <div class="page-title" data-aos="fade">
        <nav class="breadcrumbs">
          <div class="container">
            <ol>
              <li><a href="index.html">Home</a></li>
              <li class="current">Course Details</li>
            </ol>
          </div>
        </nav>
      </div><!-- End Page Title -->
      
      <section id="knowledges-knowledge-details" class="knowledges-knowledge-details section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                <h3>{{ $article->title }}</h3>
                
                        @if($article->source->name == 'YOUTUBE')
                          <p>{!! $article->content !!}</p>
                        @elseif($article->source->name == 'MP4')
                          <video width="855" height="360" controls>
                              <source src="{{ asset('storage/' . $article->file_path) }}" type="video/mp4">
                              Your browser does not support the video tag.
                          </video>
                        @elseif($article->source->name == 'OGG')
                          <video width="855" height="500" controls>
                              <source src="{{ asset('storage/' . $article->file_path) }}" type="video/mp4">
                              Your browser does not support the video tag.
                          </video>
                        @elseif($article->source->name == 'PDF')
                          <iframe src="{{ asset('storage/' . $article->file_path) }}" width="855" height="500"></iframe>
                        @else 

                        @endif
                        
                        <div class="knowledge-info d-flex justify-content-between align-items-center">
                            <div class="info-profile d-flex align-items-center">
                              Publikasi: {{ $article->tanggal_indo }}
                            </div>
                            <div class="knowledge-info-rank d-flex align-items-center">
                              <i class="bi bi-eye eye-icon"></i>&nbsp;0
                              &nbsp;&nbsp;
                              <i class="bi bi-person user-icon"></i>&nbsp;50
                              &nbsp;&nbsp;
                              <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;65
                            </div>
                        </div>
                        <hr>
                        {{ $article->content }}                  
                </div>
                <div class="col-lg-4">
                    <div class="knowledges-knowledge-lainnya">
                        <h3>Knowledge Lainnya</h3>
                        
<div class="related-articles">
    @foreach($relatedArticles as $related)
    <div class="row mt-4 mb-3 align-items-center">
        <!-- Kolom untuk thumbnail -->
        <div class="col-md-6">
            <img src="{{ asset('img/rectangle-17.png') }}" class="img-fluid rounded" alt="{{ $related->title }}">
        </div>
        
        <!-- Kolom untuk konten -->
        <div class="col-md-6">
            <h6 class="mb-1">
                <a href="{{ route('knowledges.show', $related->id) }}" class="text-decoration-none">
                    {{ $related->title }}
                </a>
            </h6>
            <div class="d-flex small text-muted gap-3">
                <div>
                    <i class="bi bi-calendar me-1"></i>
                    {{ $related->created_at->format('d M Y') }}
                </div>
                <div>
                    <i class="bi bi-eye me-1"></i>
                    {{ $related->views }} views
                    
                          &nbsp;&nbsp;
                          <i class="bi bi-people user-icon"></i>&nbsp;0
                          &nbsp;&nbsp;
                          <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

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
