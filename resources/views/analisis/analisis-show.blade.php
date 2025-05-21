@extends('layouts.app')

@section('content')
<section id="analisis" class="analisis section">
    @include('section.page-title')
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
            <h4 class="mb-0">{{ $analisis->name }}</h4>
                <div class="row">
                    
                        @if($neracas->count() > 0)
                            @foreach($neracas as $neraca)
                                
                                <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0" data-aos="zoom-in" data-aos-delay="100">
                                    <div class="analisis-item mb-4">
                                    <div class="analisis-content">
                                        <img src="{{ asset('img/rectangle-23.png') }}" class="img-fluid" alt="...">
                                        <h3 class="mt-4"><a href="{{ route('neraca.show', $neraca->slug) }}">{{ $neraca->name }}</a></h3>
                                        <small class="text-muted small">
                                            {{ $neraca->created_at->format('d M Y') }} • 
                                            {{ $neraca->analisis->name }}
                                        </small>
                                    </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-4">
                                {{ $neracas->links() }}
                            </div>
                        @else
                            <div class="alert alert-info">
                                Belum ada analisis untuk kategori ini.
                            </div>
                        @endif
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    .list-group-item.active {
        background-color: #e9f5ff;
        border-left: 3px solid #0d6efd;
        color: #0d6efd;
        font-weight: 500;
    }
</style>
@endpush