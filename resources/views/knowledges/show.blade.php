@extends('layouts.app')
@section('content')
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
@endsection


