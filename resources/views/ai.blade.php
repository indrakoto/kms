@extends('layouts.app')

@section('title', 'AI')
@section('body-class', 'ai-page')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">
@endpush

@section('content')
    <!-- Courses Section -->
    <section id="courses" class="courses section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Help</h2>
        <p>Chatbot AI</p>
        <div class=" py-4">
          
            <div id="chat-box" class="border rounded p-3 mb-3" style="height: 400px; overflow-y: scroll;">
                <!-- Pesan akan ditampilkan di sini -->
            </div>

            <div class="input-group">
                <input type="text" id="user-input" class="form-control" placeholder="Ketik pesan...">
                <button id="send-btn" class="btn btn-primary">Kirim</button>
            </div>
        </div>
      </div><!-- End Section Title -->

    </section><!-- /Courses Section -->
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/chat.js') }}"></script>
@endpush
