@extends('layouts.app')

@section('title', 'KMS - Knowledge')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/mysidebar.css') }}">
@endpush

@section('content')
    @include('section.page-title')
    <!-- Knowledges Section -->
    <section id="knowledges" class="knowledges section">
        <div class="container">
            <div class="row">
                <!-- Sidebar untuk memilih Institusi -->
                <div class="col-lg-3">
                    <div class="menu-myside">
                        
                    </div>
                </div>

                <!-- Konten untuk Artikel Knowledge -->
                <div class="col-lg-9">
                    @livewire('knowledge-search')
                </div>
            </div>
        </div>
    </section>
        
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/mysidebar.js') }}"></script>
@endpush