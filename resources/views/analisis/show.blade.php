@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- SIDEBAR -->
        <div class="col-md-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Kategori Analisis</h5>
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('analisis.index') }}" 
                       class="list-group-item list-group-item-action {{ !$activeAnalisis ? 'active' : '' }}">
                       Semua Neraca
                    </a>
                    
                    @foreach($analisisList as $item)
                        <a href="{{ route('analisis.show', $item->slug) }}" 
                           class="list-group-item list-group-item-action {{ $activeAnalisis == $item->id ? 'active' : '' }}">
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
                    <h4 class="mb-0">{{ $analisis->name }}</h4>
                    <p class="text-muted mb-0">{{ $analisis->description }}</p>
                </div>

                <div class="card-body">
                    @if($neracas->count() > 0)
                        @foreach($neracas as $neraca)
                            <div class="neraca-item border-bottom pb-3 mb-3">
                                <h5>
                                    <a href="{{ route('neraca.show', $neraca->slug) }}" class="text-decoration-none">
                                        {{ $neraca->name }}
                                    </a>
                                </h5>
                                <p class="text-muted small">
                                    {{ $neraca->created_at->format('d M Y') }} • 
                                    {{ $neraca->analisis->name }}
                                </p>
                                <p>{{ Str::limit($neraca->description, 200) }}</p>
                                <a href="{{ route('neraca.show', $neraca->slug) }}" class="btn btn-sm btn-primary">
                                    Baca Selengkapnya
                                </a>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            {{ $neracas->links() }}
                        </div>
                    @else
                        <div class="alert alert-info">
                            Belum ada neraca untuk kategori ini.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
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