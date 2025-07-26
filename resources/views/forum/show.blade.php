@extends('layouts.app')

@section('title', 'Forum')


@section('content')
<!-- Forum Section -->
<section id="forum" class="forum section">
        @include('section.page-title')
    <div class="container">
        
        <a href="{{ route('forum.index') }}" class="btn btn-link">&larr; Kembali ke daftar thread</a>
        <h3 class="mb-4">Thread</h3>
        <div class="card mb-3 border rounded" style="border-color: #e0e0e0 !important;">
            <div class="card-body p-3">
                <div class="d-flex">
                    <!-- Foto profil di sebelah kiri -->
                    <div class="me-3">
                        <img src="{{ asset($thread->user->photo ?: '/img/user-icon.png') }}" 
                                class="rounded-circle" 
                                width="48" 
                                height="48" 
                                alt="Profile">
                    </div>
                    
                    <!-- Konten utama -->
                    <div class="flex-grow-1">
                        <h5 class="card-title mb-1">
                            <a href="{{ route('forum.threads.show', $thread->id) }}" class="text-decoration-none">
                                {{ $thread->title }}
                            </a>
                        </h5>
                        <small class="text-muted">Diposting oleh: {{ $thread->user->name }} • {{ $thread->created_at->diffForHumans() }}</small>
                        
                        <p class="card-text text-muted mt-2 mb-2">{!! Str::limit($thread->content, 100) !!}</p>
                    </div>
                </div>


                <!-- Form Balas Thread -->
                @guest
                    <div class="mt-4 mb-4">
                        <a href="/login" class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                        </a>
                        <a href="/registrasi" class="btn btn-outline-success btn-sm">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Registrasi
                        </a>
                        <span class="text-muted ms-2 small">bila belum punya akses</span>
                    </div>
                @endguest
                @auth
                <div class="mt-4 mb-4">
                    <form action="{{ route('forum.threads.replies.store', $thread->id) }}" method="POST">
                        @csrf
                        <textarea name="content" class="form-control mb-2" rows="3" placeholder="Tulis balasan Anda..." required></textarea>
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" style="border-radius: 6px; font-size: 0.85rem;">
                                <i class="bi bi-send"></i> Kirim Balasan
                            </button>
                        </div>
                    </form>
                </div>
                @endauth

                <!-- Daftar Balasan -->
                <div class="mt-4 mb-4">
                    <h3>Balasan</h3>
                    @foreach ($thread->replies as $reply)
                        <div class="card mb-2">
                            <div class="card-body p-3">
                                <div class="d-flex">
                                    <!-- Foto profil di sebelah kiri -->
                                    <div class="me-3">
                                        <img src="{{ asset($reply->user->photo ?: '/img/user-icon.png') }}" 
                                                class="rounded-circle" 
                                                width="48" 
                                                height="48" 
                                                alt="Profile">
                                        
                                    </div>
                                    <div class="flex-grow-1">
                                        <p>{{ $reply->content }}</p>
                                        <small>oleh {{ $reply->user->name }} - {{ $reply->created_at->diffForHumans() }}</small>
                                    </div>

                                </div>
                                
                                
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>




    </div>
</section>
@endsection
