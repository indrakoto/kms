@extends('layouts.app')

@section('title', 'KMS - Knowledge')

@section('content')
    <!-- Knowledges Section -->
    <section id="knowledges" class="knowledges section">
        <div class="container">
            <div class="row">
                <!-- Sidebar untuk memilih Institusi -->
                <div class="col-lg-3">
                    <div class="list-group">
                        <a 
                            href="{{ route('knowledges.index') }}" 
                            class="list-group-item list-group-item-action {{ request('institusi') ? '' : 'active-institusi' }}">
                            Semua Institusi
                        </a>
                        @foreach ($institusi as $inst)
                            <a 
                                href="{{ route('knowledges.index', ['institusi' => $inst->id]) }}" 
                                class="list-group-item list-group-item-action {{ request('institusi') == $inst->id ? 'active-institusi' : '' }}">
                                {{ $inst->name }}
                            </a>
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
                                        <img src="{{ $thumbnail }}" class="img-fluid" alt="Thumbnail">
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
                                        <h3 class="mt-4"><a href="{{ route('knowledges.show', $article->id) }}">{{ $article->title }}</a></h3>
                                        <p class="description">Institusi: </p>
                                        <div class="trainer d-flex justify-content-between align-items-center">
                                            <div class="trainer-profile d-flex align-items-center">
                                                Publik/Private
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
