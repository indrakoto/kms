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
                <div class="col-lg-12">
                    @livewire('knowledge-search')
                </div>
            </div>
        </div>
    </section>
        
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/mysidebar.js') }}"></script>
@endpush