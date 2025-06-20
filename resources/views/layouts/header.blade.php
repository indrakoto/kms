@php
  $menus = [
    ['label' => 'Beranda', 'url' => '/beranda'],
    ['label' => 'Analisis', 'url' => '/analisis'],
    ['label' => 'Knowledge', 'url' => '/knowledge'],
    ['label' => 'Geo-Portal', 'url' => '/geo-portal'],
    ['label' => 'Forum', 'url' => '/forum'],
    ['label' => '<img  height="18px" src="' . asset('img/LogoAlphaByteBlack.png') . '" />&nbsp;AlphaByte.', 'url' => '/ai', 'raw' => true, 'class' => ''],
  ];

  if(Auth::check()) {

    // Nama user menu
    $menus[] = [
      'label' => '<button type="button" class="btn btn-success btn-sm">' . Auth::user()->name . '</button>',
      'url' => '#',
      'raw' => true, // agar label HTML tidak di-escape
    ];

    // Jika user role admin atau teknis, tambahkan menu Administrator
    if (in_array(Auth::user()->role, ['admin', 'teknis'])) {
        $menus[] = [
          'label' => '<button type="button" class="btn btn-warning btn-sm"><i class="bi bi-box-arrow-right"></i> ke Admin Page</button>',
          'url' => '/administrator/dashboard',
          'raw' => true, // Karena label berisi HTML, harus true agar tidak di-escape
        ];
    }




    // Logout menu (gunakan form POST untuk logout keamanan CSRF)
    $menus[] = [
      'label' => '<form action="' . route('logout') . '" method="POST" style="display:inline;">
                    ' . csrf_field() . '
                    <button type="submit" title="Logout" class="btn btn-danger btn-sm">
                      <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                  </form>',
      'url' => '#',
      'raw' => true,
    ];
  } else {
    $menus[] = [
      'label' => '<button type="button" class="btn btn-success btn-sm"><i class="bi bi-file-lock2-fill"></i> Login &nbsp;</button>',
      'url' => '/login',
      'raw' => true,
    ];
  }
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
    </div>
</header>