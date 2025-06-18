@extends('layouts.app')
@section('title', 'Forum')

@section('content')
<div class="container">
    <h1>Forum Threads</h1>

    
    <!-- Form Buat Thread -->
    <div class="mb-4">
        <h3>Buat Thread Baru</h3>
        <form action="{{ route('forum.storeThread') }}" method="POST">
            @csrf
            <input type="text" name="title" class="form-control mb-2" placeholder="Judul thread" required>
            <textarea name="content" class="form-control mb-2" placeholder="Isi thread" rows="4" required></textarea>
            <button class="btn btn-primary">Kirim</button>
        </form>
    </div>

</div>
@endsection
