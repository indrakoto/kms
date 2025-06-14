@extends('layouts.app')

@section('title', 'AI')
@section('body-class', 'ai-page')

@push('styles')
  <!-- Font Awesome CDN v6.5.0 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">
@endpush

@section('content')
    <!-- Courses Section -->
    <section id="general" class="general section">
    
      <div class="container" data-aos="fade-up">
        <div class="box">
            <div>
                <div class="text-center">
                  <img width="50%"
                    src="{{ asset('img/AlphaByteBlack.png') }}"
                    style="display: block; margin-left: auto; margin-right: auto;"
                    alt="Logo"
                  />
                </div>

                <div class="mt-4">
                    <div id="chat-box" class="mb-3" style="height: 400px; overflow-y: scroll;">
                        <!-- Pesan akan ditampilkan di sini -->
                    </div>

                </div>
            </div>
            <div class="input-wrapper">
                <textarea id="user-input" class="chat-input" placeholder="Tulis pesan..."></textarea>
                <button class="send-btn">
                  <i class="fas fa-paper-plane"></i>
                </button>
            </div>
        </div>

      </div><!-- End Section Title -->
    </section><!-- /general Section -->
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/ai.js') }}"></script>
@endpush
