@extends('layouts.app')

@section('content')
<section id="analisis" class="analisis section">
    <div class="container">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-lg-3">
                <div class="card shadow-sm mb-4">

                    <div class="list-group">
                        <a href="{{ route('analisis.index') }}" 
                        class="list-group-item list-group-item-action {{ !$activeAnalisis ? 'active-analisis' : '' }}">
                        Semua Analisis
                        </a>
                        
                        @foreach($analisisList as $item)
                            <a href="{{ route('analisis.show', $item->slug) }}" 
                            class="list-group-item list-group-item-action {{ $activeAnalisis == $item->id ? 'active-analisis' : '' }}">
                            {{ $item->name }}
                            <span class="badge bg-secondary float-end">{{ $item->neracas_count }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- MAIN CONTENT -->
            <div class="col-md-9">
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('analisis.index') }}">Analisis</a>
                                </li>
                                <li class="breadcrumb-item">
                                    <a href="{{ route('analisis.show', $neraca->analisis->slug) }}">
                                        {{ $neraca->analisis->name }}
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ Str::limit($neraca->name, 30) }}
                                </li>
                            </ol>
                        </nav>
                    </div>

                    <div class="card-body">
                        <article>
                            <h1 class="mb-3">{{ $neraca->name }}</h1>
                            
                            <div class="meta d-flex gap-3 text-muted mb-4">
                                <div>
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $neraca->created_at->format('d M Y') }}
                                </div>
                                <div>
                                    <i class="fas fa-tag me-1"></i>
                                    <a href="{{ route('analisis.show', $neraca->analisis->slug) }}" 
                                    class="text-decoration-none">
                                    {{ $neraca->analisis->name }}
                                    </a>
                                </div>
                            </div>

                            <div class="content">
                                {!! $neraca->description !!}
                            </div>
                        </article>

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