@extends('layouts.app')

@section('title', 'KMS-Analisis')

@section('content')

<section id="analisis" class="analisis-details section">
    @include('section.page-title',['analisis'=>$analisis])
    <div class="container">  <!-- Ganti container menjadi container-fluid dan hapus padding horizontal -->
        <div class="row">  <!-- Tambahkan g-0 untuk menghilangkan gutter -->
            <!-- MAIN CONTENT -->
            <div class="col-lg-12">
                <h3 class="mb-3">{{ $analisis->title }}</h3>
                <div class="mb-4" style="border: 1px solid #cccccc; padding:5px;">            
                            <!-- Awal bagian Konten , PDF, Video  , Link atau Youtube --> 
                            @php
                            $sourceType = strtolower($analisis->source->name);
                            @endphp
                        
                            @switch($sourceType)
                            @case('text')
                                <div class="article-content">
                                    {!! $analisis->content !!}
                                </div>
                                @break

                            @case('pdf')
                                <div class="ratio ratio-16x9 mb-4">
                                    <iframe src="{{ Storage::url($analisis->file_path) }}#toolbar=0" 
                                            style="border: none;"></iframe>
                                </div>
                                @break

                            @case('video')
                                @if($analisis->embed_code)
                                    <div class="ratio ratio-16x9 mb-4">
                                        {!! $analisis->embed_code !!}
                                    </div>
                                @else
                                    <video controls class="w-100 mb-4">
                                        <source src="{{ Storage::url($analisis->video_path) }}" type="video/mp4">
                                    </video>
                                @endif
                                @break

                        
                            @case('youtube')
                                <div class="ratio ratio-16x9 mb-4">
                                    {!! $analisis->embed_code !!}
                                </div>
                                @break

                            @case('link')
                                <div class="ratio ratio-21x9">
                                    <iframe src="{{ $analisis->embed_link }}#toolbar=0" 
                                        style="border: none;"></iframe>
                                </div>
                                @break

                            @case('tableau')
                                <!--<script type="module" src="https://public.tableau.com/javascripts/api/tableau.embedding.3.latest.min.js"></script>-->
                                <script type='module' src='https://dashboard.esdm.go.id/javascripts/api/tableau.embedding.3.latest.min.js'></script>
                                <div>
                                    <tableau-viz
                                        id="tableauViz"
                                        src="{{ $url }}"
                                        token="{{ $token }}"
                                        device="desktop"
                                        toolbar="bottom"
                                        hide-tabs
                                        style="display:block;">
                                    </tableau-viz>
                                </div>
                                <!--<script type="module" src="https://cdn.jsdelivr.net/npm/@tableau/tableau-viz@1.6.0/dist/tableau-viz.min.js"></script>-->
                                @break
                            @default
                                <div class="alert alert-warning">
                                    Format konten tidak dikenali
                                </div>

                            @endswitch
                            <!-- Akhir bagian Konten , PDF, Video  , Link atau Youtube -->                         
                       
                    
                </div>
            </div>
        </div>
    </div>
</section>

<section id="analisis" class="analisis section">
    <div class="container">
        <h3 class="mt-4 mb-4">Analisis Lainnya</h3>
        <div class="row">
            
            @foreach($analisisList as $aList)
              <div class="col-lg-3 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
                <div class="analisis-item mb-4">
                  <div class="analisis-content">
                    <img src="{{ asset('img/rectangle-23.png') }}" class="img-fluid" alt="...">
                    <h3 class="mt-3"><a href="{{ route('detail.show', ['article_slug' => $aList->slug, 'id' => $aList->id]) }}">{{ $aList->short_title }}</a></h3>

                    <div class="box-footer d-flex justify-content-between align-items-center pt-1 pb-1 pr-1 pl-3">
                        <div class="trainer-profile d-flex align-items-center">
                          <!-- isi dengan institusi -->
                        </div>
                        <div class="trainer-rank d-flex align-items-center">
                            <i class="bi bi-eye eye-icon"></i>&nbsp;0
                            &nbsp;&nbsp;
                            <i class="bi bi-star-fill start-icon" style="color:rgb(233, 187, 89);"></i>&nbsp;0
                        </div>
                    </div>  
                  </div>
                </div>
              </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
