@extends('layouts.app')

@section('title', 'KMS - Knowledge')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/mysidebar.css') }}">
@endpush

@section('content')
    @include('section.page-title')
    <!-- Knowledges Section -->
    <section id="knowledges" class="knowledges section">
        <div class="container">
            <div class="row">
                <!-- Sidebar untuk memilih Institusi -->
                <div class="col-lg-3">
                    <div class="menu-myside">
                        @foreach ($institusis as $item)
                            @include('section.sidebar-knowledge', ['item' => $item])
                        @endforeach
                    </div>
                </div>

                <!-- Konten untuk Artikel Knowledge -->
                <div class="col-lg-9">
                    <div class="row">
                        @foreach ($knowledges as $article)
                            <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
                                <div class="knowledge-item mb-4">
                                    <div class="knowledge-content">
                                        @php
                                            $thumbnail = $article->thumbnail 
                                                ? asset('articles/thumbnails/' . $article->thumbnail)
                                                : asset('img/default.png');
                                        @endphp
                                        <img src="{{ $thumbnail }}" class="img-fluid rounded" alt="Thumbnail"  style="border: 1px solid #f1f1f1;" >
                                        <div class="d-flex justify-content-between align-items-center">
                                            @if($article->source->name == 'YOUTUBE')
                                                <span class="badges-youtube"><i class="bi bi-youtube"></i></span>
                                            @elseif($article->source->name == 'VIDEO')
                                                <span class="badges-video"><i class="bi bi-play-circle-fill"></i></span>
                                            @elseif($article->source->name == 'PDF')
                                                <span class="badges-pdf"><i class="bi bi-file-pdf"></i></span>
                                            @elseif($article->source->name == 'LINK')
                                                <span class="badges-link"><i class="bi bi-globe"></i></span>
                                            @endif
                                        </div>
                                        <h3 class="mt-4"><a href="{{ route('knowledge.show', ['article_slug' => $article->slug, 'id' => $article->id]) }}">{{ $article->title }}</a></h3>
                                        <p class="description" style="margin-bottom: 0;">{{ $article->institusi->name }}</p>
                                        <div class="trainer d-flex justify-content-between align-items-center">
                                            <div class="trainer-profile d-flex align-items-center">
                                                Publikasi: {{ $article->created_at->format('d M Y') }}
                                            </div>
                                            <div class="trainer-rank d-flex align-items-center">
                                                <i class="bi bi-eye eye-icon"></i>&nbsp;0
                                                &nbsp;&nbsp;
                                                <i class="bi bi-people user-icon"></i>&nbsp;0
                                                &nbsp;&nbsp;
                                                <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- End Knowledge Item-->
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="row">
                        <div class="mt-4">
                            {{ $knowledges->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /Knowledges Section -->
@endsection
@push('scripts')
  <script src="{{ asset('assets/js/mysidebar.js') }}"></script>
@endpush