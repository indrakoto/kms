<div class="">

    <!-- Search Form -->
      <form class="page-title__search" style="padding: 0 250px 80px 250px;">
        @csrf
        <div class="page-title__search-group">
          <input 
            type="text" 
            wire:model.live.debounce.500ms="search" 
            class="page-title__search-input" 
            placeholder="Search..." 
            name="q"
            aria-label="Search articles"
            autocomplete="off"
          >
          <button class="page-title__search-btn" type="submit" aria-label="Submit search">
            Search
          </button>
        </div>
      </form>

    <!-- Loading Indicator -->
    <div wire:loading class="mb-4 text-blue-500">Mencari...</div>

    <!-- Results -->
    <div wire:loading.remove>

    </div>
    @if($results->isNotEmpty())
        <div class="row">
            @foreach($results as $article)
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
                                        <h3 class="mt-3"><a href="{{ route('knowledge.show', ['article_slug' => $article->slug, 'id' => $article->id]) }}">{{ $article->title }}</a></h3>
                                        <p class="description" style="margin-bottom: 0;">{{ $article->institusi->name }}</p>
                                        <div class="trainer d-flex justify-content-between align-items-center">
                                            <div class="trainer-profile d-flex align-items-center">
                                                {{ $article->created_at->format('d M Y') }}
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

                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-6">
                {{ $results->withQueryString()->links() }}
            </div>
        </div>
    @elseif($search)
        <p class="text-gray-500">Tidak ditemukan hasil untuk "{{ $search }}"</p>
        @if($search)
            <p class="text-gray-500">Tidak ditemukan hasil untuk "{{ $search }}"</p>
        @else
            <p class="text-gray-500">Masukkan kata kunci pencarian</p>
        @endif
    @endif
</div>