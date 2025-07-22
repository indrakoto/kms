@extends('layouts.app')

@section('title', 'KMS - Knowledge')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/mysidebar.css') }}">
@endpush

@section('content')
    <!-- Knowledges Section -->
    <section id="knowledges" class="knowledges section">
        @include('section.page-title')
        <div class="container">
            <div class="row">
                <!-- Sidebar untuk memilih Institusi -->
                <div class="col-lg-3">
                    <div class="mb-4">
                        <!-- Include Search Form -->
                        @include('section.search')
                    </div>
                    <div class="menu-myside">
                        @foreach ($institusis as $item)
                            @include('section.sidebar-knowledge', ['item' => $item])
                        @endforeach
                    </div>
                </div>

                <!-- Konten untuk Artikel Knowledge (Livewire) -->
                <div class="col-lg-9">
                    @livewire('knowledge-list')
                </div>
            </div>
        </div>
    </section>
    <!-- /Knowledges Section -->
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/mysidebar.js') }}"></script>
@endpush
