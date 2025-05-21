@extends('layouts.app')

@section('title', 'AI')
@section('body-class', 'ai-page')

@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/chat.css') }}">
@endpush

@section('content')
    <!-- Courses Section -->
    <section id="general" class="general section">
    
      <div class="container" data-aos="fade-up">
        <div class="card">
            <div class="card-body">
                <div class="text-center"><img height="100px" src="{{  asset('img/AlphaByteBlack.png') }}" /></div>
                <div class=" py-4">
                    <div id="chat-box" class="p-3 mb-3" style="height: 400px; overflow-y: scroll;">
                        <!-- Pesan akan ditampilkan di sini -->
                    </div>


                </div>
            </div>
            <div class="card-footer">
                <div class="input-group">
                    <input type="text" id="user-input" class="form-control" placeholder="Ketik pesan...">
                    <button id="send-btn" class="btn btn-primary">Kirim</button>
                </div>
            </div>
        </div>

      </div><!-- End Section Title -->
    </section><!-- /general Section -->
@endsection

@push('scripts')
  <script src="{{ asset('assets/js/ai.js') }}"></script>
@endpush
