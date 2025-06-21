@extends('layouts.app')

@section('title', 'Forum')
@push('styles')
  <link rel="stylesheet" href="{{ asset('assets/css/forum.css') }}">
@endpush
@section('content')
    <!-- Forum Section -->
    <section id="forum" class="forum section">
        @include('section.page-title')
        
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3 border rounded" style="border-color: #e0e0e0 !important;">
                        <div class="card-body">
                            <h3 class="mb-4">Forum</h3>                    
                            <div class="d-flex mb-4 justify-content-between align-items-center">
                                <div>
                                    <strong class="me-3">Recent</strong>
                                    <a href="#" class="text-decoration-none text-muted me-3">Featured</a>
                                    <a href="#" class="text-decoration-none text-muted me-3">Popular</a>
                                </div>
                                
                                <div class="d-flex align-items-center ms-auto gap-2">
                                    @if(Auth::check())
                                        <a href="{{ route('forum.tambah') }}" class="btn btn-outline-success btn-sm"><i class="bi bi-book me-1"></i> Tambah</a>
                                        <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger btn-sm d-flex align-items-center">
                                                <i class="bi bi-box-arrow-right me-1"></i> Logout
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm d-flex align-items-center">
                                            <i class="bi bi-box-arrow-in-right me-1"></i> Login
                                        </a>
                                        <a href="/registrasi" class="btn btn-outline-success btn-sm d-flex align-items-center">
                                            <i class="bi bi-box-arrow-in-right me-1"></i> Registrasi
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    @foreach($threads as $thread)
                    <div class="card mb-3 border rounded" style="border-color: #e0e0e0 !important;">
                        <div class="card-body p-3">
                            <div class="d-flex">
                                <!-- Foto profil di sebelah kiri -->
                                <div class="me-3">
                                    <img src="{{ asset($thread->user->photo ?: '/img/default-user-icon.png') }}" 
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
                                
                                <!-- Icon komentar di sebelah kanan -->
                                <div class="d-flex flex-column align-items-center justify-content-center ms-3" style="width: 60px;">
                                    <div class="d-flex align-items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6c757d" class="bi bi-chat" viewBox="0 0 16 16">
                                            <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                                        </svg>
                                        <span class="ms-1 text-muted small">{{ $thread->replies_count }}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                    
                </div>
                
                <div class="col-md-4">
                    <div class="card border rounded" style="border-color: #e0e0e0 !important;">
                        <div class="card-body">
                            <h5 class="card-title">Kontributor Teratas</h5>
                            <p class="text-muted small">Pengguna yang memiliki diskusi terbanyak.</p>
                            
                            <ul class="list-unstyled">
                                @foreach($topContributors as $contributor)
                                <li class="mb-2">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset($contributor->photo ?: '/img/default-user-icon.png') }}" class="rounded-circle me-2" width="24" height="24" alt="Profile">
                                        {{ $contributor->name }}
                                        <!-- Icon komentar di sebelah kanan -->
                                        <div class="d-flex flex-column align-items-center justify-content-center ms-3" style="width: 60px;">
                                            <div class="d-flex align-items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#6c757d" class="bi bi-chat" viewBox="0 0 16 16">
                                                    <path d="M2.678 11.894a1 1 0 0 1 .287.801 11 11 0 0 1-.398 2c1.395-.323 2.247-.697 2.634-.893a1 1 0 0 1 .71-.074A8 8 0 0 0 8 14c3.996 0 7-2.807 7-6s-3.004-6-7-6-7 2.808-7 6c0 1.468.617 2.83 1.678 3.894m-.493 3.905a22 22 0 0 1-.713.129c-.2.032-.352-.176-.273-.362a10 10 0 0 0 .244-.637l.003-.01c.248-.72.45-1.548.524-2.319C.743 11.37 0 9.76 0 8c0-3.866 3.582-7 8-7s8 3.134 8 7-3.582 7-8 7a9 9 0 0 1-2.347-.306c-.52.263-1.639.742-3.468 1.105"/>
                                                </svg> &nbsp; {{ $contributor->threads_count }}
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
    </section><!-- /Forum Section -->
@endsection