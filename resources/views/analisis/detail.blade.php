@extends('layouts.app')

@section('title', 'KMS-Analisis')

@section('content')

<section id="analisis" class="analisis section">
    @include('section.page-title',['analisis'=>$analisis])
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="mb-4">
                    <div class="list-group" style="border-radius: 0;">
                        <a href="{{ route('analisis.index') }}" 
                        class="list-group-item list-group-item-action {{ !$activeAnalisis ? 'active-analisis' : '' }}">
                        Semua Analisis
                        </a>
                        
                        @foreach($analisisList as $aList)
                            <a href="{{ route('detail.show', ['article_slug' => $aList->slug, 'id' => $aList->id]) }}" 
                            class="list-group-item list-group-item-action {{ $activeAnalisis == $aList->id ? 'active-analisis' : '' }}">
                            {{ $aList->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="mb-4">
                    <div class="list-group" style="border-radius: 0;">
                        <a href="#" class="list-group-item list-group-item-action active-analisis">
                            Layanan Publik
                        </a>
                        @foreach($layananList as $item)
                            @if($item->redirect_link==1)
                                <a class="list-group-item list-group-item-action" href="{{ $item->embed_link }}" target="_blank">{{ $item->title }}</a>
                            @else
                                <a href="{{ route('detail.show', ['article_slug' => $item->slug, 'id' => $item->id]) }}" 
                                    class="list-group-item list-group-item-action {{ $activeAnalisis == $item->id ? 'active-analisis' : '' }}">
                                    {{ $item->title }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-lg-9 overflow-hidden">
                <div class="mb-4" style="border: 1px solid rgb(232, 232, 232);">
                    <div>
                        
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
                                <div class="ratio ratio-16x9 mb-4">
                                    <iframe src="{{ $analisis->embed_link }}#toolbar=0" 
                                        style="border: none;"></iframe>
                                </div>
                                @break

                            @case('tableau')
                                <!--<script type="module" src="https://public.tableau.com/javascripts/api/tableau.embedding.3.latest.min.js"></script>-->
                                <script type='module' src='https://dashboard.esdm.go.id/javascripts/api/tableau.embedding.3.latest.min.js'></script>
                                <div class="w-100" style="height: calc(100vh - 120px); overflow: hidden;">
                                    <tableau-viz
                                        id="tableauViz"
                                        src="{{ $url }}"
                                        token="{{ $token }}"
                                        device="desktop"
                                        toolbar="bottom"
                                        hide-tabs
                                        class="w-full h-full">
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
    </div>
</section>
@endsection
