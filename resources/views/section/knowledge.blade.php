    <!-- Knowledges Section -->
    <section id="knowledges" class="knowledges section">
      <div class="container">
        <div class="row">
        <h3 class="text-center mb-4">Knowledge Terbaru</h3>
        @foreach ($latestArticles as $article)
          <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
            <div class="knowledge-item">
              
              <div class="knowledge-content">
                @php
                    $thumbnail = $article->thumbnail 
                        ? asset('articles/thumbnails/' . $article->thumbnail)
                        : asset('img/default.png');
                @endphp
                <img src="{{ $thumbnail }}" class="img-fluid mb-3" alt="Thumbnail">
                <div class="d-flex justify-content-between align-items-center">
                  @if($article->source->name == 'YOUTUBE')
                    <span class="badges-youtube"><i class="bi bi-youtube"></i></span>
                  @elseif($article->source->name == 'MP4')
                    <span class="badges-video"><i class="bi bi-play-circle-fill"></i></span>
                  @elseif($article->source->name == 'OGG')
                  <span class="badges-video"><i class="bi bi-play-circle-fill"></i></span>
                  @elseif($article->source->name == 'PDF')
                    <span class="badges-pdf"><i class="bi bi-file-pdf" style=""></i></span>
                  @else 
                  @endif
                  <!-- <p class="category">{{ $article->category->name }}</p> -->
                </div>

                <h3><a href="{{ route('knowledges.show', $article->id) }}">{{ $article->title }}</a></h3>
                
                <div class="trainer d-flex justify-content-between align-items-center pt-1 pb-1 pr-1 pl-3 ">
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
          </div> <!-- End Course Item-->
        @endforeach

          <div class="mt-4 text-center"><a href="/knowledge" class="read-more"><span>Lihat Selengkapnya</span><i class="bi bi-arrow-right"></i></a></div>
        </div>
        
      </div>
    </section>
    <!-- /Knowledges Section -->