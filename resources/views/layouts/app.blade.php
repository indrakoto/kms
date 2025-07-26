<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'KMS MIGAS')</title>
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <link href="{{ asset('img/logo-esdm.png') }}" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">

  <!-- Vendor CSS -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

  <!-- Default to light mode -->
  <link rel="stylesheet" href="{{ asset('assets/css/light.css') }}" id="theme-link" />

  @stack('styles')
  @livewireStyles
</head>

<body class="@yield('body-class', 'default-page')">

  @include('layouts.header')
  <main class="main">
    @yield('content')
  </main>

  @include('layouts.footer')

  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets/js/main.js') }}"></script>
  @livewireScripts

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleThemeBtn');
        const themeLink = document.getElementById('theme-link');
        const iconSun = toggleBtn ? toggleBtn.querySelector('.bi-sun') : null;
        const iconMoon = toggleBtn ? toggleBtn.querySelector('.bi-moon') : null;

        function switchTheme(theme) {
            if (theme === 'dark') {
                themeLink.href = "{{ asset('assets/css/dark.css') }}";
                if (iconSun && iconMoon) {
                    iconSun.style.display = 'none';
                    iconMoon.style.display = 'inline';
                }
                localStorage.setItem('theme', 'dark');
            } else {
                themeLink.href = "{{ asset('assets/css/light.css') }}";
                if (iconSun && iconMoon) {
                    iconSun.style.display = 'inline';
                    iconMoon.style.display = 'none';
                }
                localStorage.setItem('theme', 'light');
            }
        }

        // Cek preferensi yang sudah tersimpan di localStorage
        let savedTheme = localStorage.getItem('theme');

        if (!savedTheme) {
            // Jika belum ada preferensi, cek preferensi sistem/browser dengan media query
            if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
                savedTheme = 'dark';
            } else {
                savedTheme = 'light';
            }
        }

        // Terapkan tema yang ditemukan
        switchTheme(savedTheme);

        // Event listener toggle tombol
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                const currentTheme = localStorage.getItem('theme');
                switchTheme(currentTheme === 'light' ? 'dark' : 'light');
            });
        }
    });
</script>
@endpush



  @stack('scripts')
</body>
</html>
