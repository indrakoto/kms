@php
  $menus = [
    ['label' => 'Beranda', 'url' => '/beranda'],
    ['label' => 'Analisis', 'url' => '/analisis'],
    ['label' => 'Knowledge', 'url' => '/knowledge'],
    ['label' => 'Geo-Portal', 'url' => '/geo-portal'],
    ['label' => '<img  height="18px" src="' . asset('img/LogoAlphaByteBlack.png') . '" /> &nbsp; AI', 'url' => '/ai', 'raw' => true, 'class' => ''],
    ['label' => '<i class="bi bi-file-lock2-fill text-warning" style="font-size:xx-large;"></i>', 'url' => '/login', 'raw' => true],
  ];
@endphp

<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="/" class="logo d-flex align-items-center me-auto">
        <img src="{{ asset('img/KMS-by-DIRJEN-MIGAS-02-1.png') }}" />
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
        @foreach ($menus as $menu)
          <li>
            <a 
              href="{{ $menu['url'] }}" 
              class="{{ request()->is(ltrim($menu['url'], '/')) ? 'active' : '' }} {{ $menu['class'] ?? '' }}">
              {!! $menu['raw'] ?? false ? $menu['label'] : e($menu['label']) !!}
            </a>
          </li>
        @endforeach
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
      
      <!--
        <form action="#" method="post" class="searchx">
            <div class="search-form"><input type="text" name="search"></div>
        </form>
      -->

    </div>
</header>