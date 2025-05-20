@extends('layouts.app')
@section('content')
    @include('section.page-title')
      
      <section id="knowledges-knowledge-details" class="knowledges-knowledge-details section">
        <div class="container">
            <div class="row">
                <div class="col-lg-9">
                <h3 class="mb-2">{{ $article->title }}</h3>
                <div style="border: 1px solid #cccccc; padding:5px;">
                <!-- Awal bagian Konten , PDF, Video  , Link atau Youtube --> 
                @php
                  $sourceType = strtolower($article->source->name);
                @endphp
                
                @switch($sourceType)
                  @case('text')
                      <div class="article-content">
                          {!! $article->content !!}
                      </div>
                      @break

                  @case('pdf')
                      <div class="ratio ratio-16x9 mb-4">
                          <iframe src="{{ Storage::url($article->file_path) }}#toolbar=0" 
                                  style="border: none;"></iframe>
                      </div>
                      @break

                  @case('video')
                      @if($article->embed_code)
                          <div class="ratio ratio-16x9 mb-4">
                              {!! $article->embed_code !!}
                          </div>
                      @else
                          <video controls class="w-100 mb-4">
                              <source src="{{ Storage::url($article->video_path) }}" type="video/mp4">
                          </video>
                      @endif
                      @break

              
                  @case('youtube')
                      <div class="ratio ratio-16x9 mb-4">
                          {!! $article->embed_code !!}
                      </div>
                      @break

                  @case('link')
                      <div class="ratio ratio-16x9 mb-4">
                        <iframe src="{{ $article->embed_link }}#toolbar=0" 
                            style="border: none;"></iframe>
                      </div>
                      @break

                  @default
                      <div class="alert alert-warning">
                          Format konten tidak dikenali
                      </div>

                @endswitch
                <!-- Akhir bagian Konten , PDF, Video  , Link atau Youtube -->                         
                </div>
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
                <div class="col-lg-3">
      <!-- Search Form -->
      <form class="page-title__search" action="/search" method="GET">
        <div class="page-title__search-group">
          <input 
            type="text" 
            class="page-title__search-input" 
            placeholder="Search..." 
            name="q"
            aria-label="Search articles"
          >
          <button class="page-title__search-btn" type="submit" aria-label="Submit search">
            Search
          </button>
        </div>
      </form>
                    <div class="knowledges-knowledge-lainnya">
                        <h3>Knowledge Lainnya</h3>
                        
<div class="s">
    @foreach($relatedArticles as $related)
    <div class="knowledge-lainnya-item mt-4 mb-3 align-items-center">
        <!-- Kolom untuk thumbnail -->
        <div class="col-md-12">
            @php
                $thumbnail = $related->thumbnail 
                    ? asset('articles/thumbnails/' . $related->thumbnail)
                    : asset('img/default.png');
            @endphp
            <img src="{{ $thumbnail }}" class="img-fluid rounded" alt="{{ $related->title }}">
        </div>
        
        <!-- Kolom untuk konten -->
        <div class="col-md-12">
            <h3 class="mt-3 mb-3">
                
                <a href="{{ route('knowledge.show', ['article_slug' => $related->slug, 'id' => $related->id]) }}">
                    {{ $related->title }}
                </a>
   
            </h3>
            <div class="d-flex text-muted gap-3" style="font-size: 11px;">
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
@endsection


