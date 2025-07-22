<div>
    <div class="d-flex justify-content-end mb-3">
        <button
            wire:click="$set('viewMode', 'list')"
            class="btn me-2"
            @class(['active' => ($viewMode ?? 'list') === 'list'])
            style="background-color: #f7f7f7; border: 1px solid #ccc;"
        >
            <i class="bi bi-list"></i>
        </button>

        <button
            wire:click="$set('viewMode', 'grid')"
            class="btn"
            @class(['active' => ($viewMode ?? 'list') === 'grid'])
            style="background-color: #f7f7f7; border: 1px solid #ccc;"
        >
            <i class="bi bi-grid-3x3-gap-fill"></i>
        </button>
    </div>



    @if ($viewMode === 'list')
        <div class="row">
            @foreach ($knowledges as $article)
                <div class="col-12 mb-3">
                    <div class="knowledge-item  rounded-3 p-2 position-relative">

                        <div class="position-absolute top-0 end-0 mt-2 me-3">
                            @if($article->source->name == 'YOUTUBE')
                                <span class="badge bg-danger rounded-pill px-2 py-1 small"><i class="bi bi-youtube"></i></span>
                            @elseif($article->source->name == 'VIDEO')
                                <span class="badge bg-primary rounded-pill px-2 py-1 small"><i class="bi bi-play-circle-fill"></i></span>
                            @elseif($article->source->name == 'PDF')
                                <span class="badge bg-secondary rounded-pill px-2 py-1 small"><i class="bi bi-file-pdf"></i></span>
                            @elseif($article->source->name == 'LINK')
                                <span class="badge bg-success rounded-pill px-2 py-1 small"><i class="bi bi-globe"></i></span>
                            @endif
                        </div>


                        <div class="d-flex">
                            <div class="position-relative flex-shrink-0">
                                @php
                                    $thumbnail = $article->thumbnail 
                                        ? asset('articles/thumbnails/' . $article->thumbnail)
                                        : asset('img/default.png');
                                @endphp
                                <img src="{{ $thumbnail }}" alt="Thumbnail" class="img-fluid rounded" style="width: 120px; height: 80px; object-fit: cover; border: 1px solid #f1f1f1;">
                                

                            </div>

                            <div class="flex-grow-1 ps-3 d-flex flex-column justify-content-between">
                                <div>
                                    @if($article->redirect_link==1)
                                        <h5 class="mb-1"><a href="{{ $article->embed_link }}" target="_blank" class="">{{ $article->short_title }}</a></h5>
                                    @else
                                        <h5 class="mb-1"><a href="{{ route('knowledge.show', ['article_slug' => $article->slug, 'id' => $article->id]) }}" class="">{{ $article->short_title }}</a></h5>
                                    @endif
                                    <p class="mb-0 text-muted">Institusi: {{ $article->institusi->name }}</p>
                                </div>
                                <small class="text-muted"><i class="bi bi-calendar2-event me-1"></i>{{ $article->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @else
        <div class="row">
                        @foreach ($knowledges as $article)
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in">
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
                                    @if($article->redirect_link==1)
                                        <h3 class="mt-3"><a href="{{ $article->embed_link }}" target="_blank">{{ $article->short_title }}</a></h3>
                                    @else
                                        <h3 class="mt-3"><a href="{{ route('knowledge.show', ['article_slug' => $article->slug, 'id' => $article->id]) }}">{{ $article->short_title }}</a></h3>
                                    @endif
                                    
                                    <p class="description" style="margin-bottom: 0;">{{ $article->institusi->name }}</p>
                                    <div class="trainer d-flex justify-content-between align-items-center">
                                        <div class="trainer-profile d-flex align-items-center">
                                            <i class="bi bi-calendar2-event me-1"></i> {{ $article->created_at->format('d M Y') }}
                                        </div>
                                        <div class="trainer-rank d-flex align-items-center">
                                            <i class="bi bi-eye eye-icon"></i>&nbsp;{{ $article->views }}
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
    @endif

    <div class="d-flex justify-content-between align-items-center mt-4">
        <div>
            <small>
                Showing
                {{ $knowledges->firstItem() ?? 0 }}
                to
                {{ $knowledges->lastItem() ?? 0 }}
                of
                {{ $knowledges->total() }}
                results
            </small>
        </div>
        <div>
            {{ $knowledges->links() }}
        </div>
    </div>

</div>
