@extends('layouts.app')

@section('title', 'KMS-Analisis')

@section('content')

<section id="analisis" class="analisis section">
    @include('section.page-title', ['title'=>$neraca])
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="mb-4">
                    <div class="list-group" style="border-radius: 0;">
                        <a href="{{ route('analisis.index') }}" 
                        class="list-group-item list-group-item-action {{ !$activeAnalisis ? 'active-analisis' : '' }}">
                        Semua Analisis
                        </a>
                        
                        @foreach($analisisList as $analisis)
                            <a href="{{ route('analisis.show', $analisis->slug) }}" 
                            class="list-group-item list-group-item-action {{ $activeAnalisis == $analisis->id ? 'active-analisis' : '' }}">
                            {{ $analisis->name }}
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
                                <a class="list-group-item list-group-item-action" href="{{ route('knowledge.show', ['article_slug' => $item->slug, 'id' => $item->id]) }}">{{ $item->title }}</a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-lg-9">
                <div class="card ">
                    <div class="card-body">
                       
                            <h3 class="mb-3">{{ $neraca->name }}</h3>
                            <div class="">
                                {!! $neraca->description !!}
                            </div>
                       

                        <div class="mt-5">
                            <a href="{{ route('analisis.show', $neraca->analisis->slug) }}" 
                            class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Analisis
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    /* Style untuk konten */
    .content {
        line-height: 1.8;
    }
    
    .content p {
        margin-bottom: 1.2em;
    }
    
    .content img {
        max-width: 100%;
        height: auto;
        border-radius: 8px;
        margin: 1rem 0;
    }
    
    /* Breadcrumb */
    .breadcrumb {
        padding: 0.75rem 1rem;
        background-color: transparent;
    }
    
    /* Active menu sidebar */
    .list-group-item.active {
        background-color: #e9f5ff;
        border-left: 3px solid #0d6efd;
        color: #0d6efd;
        font-weight: 500;
    }
</style>
@endpush