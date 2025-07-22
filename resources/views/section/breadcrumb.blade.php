    <div class="page-title" data-aos="fade">
        <div class="container">
            <div class="page-title__wrapper">
                <nav class="breadcrumbs">
                    <ol>
                        @foreach ($breadcrumbs as $breadcrumb)
                        <li>
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                        </li>
                        @endforeach
                    </ol>
                </nav>
            </div>
        </div>
    </div>
