@extends('layouts.app')

@section('title', 'Tambah Artikel Forum')

@section('content')
<!-- Forum Section -->
<section id="forum" class="forum section">
    @include('section.page-title')
    <div class="container mt-4">
        <h1>Tambah Artikel Forum</h1>

        <!-- Menampilkan error jika validasi gagal -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('forum.store') }}" method="POST">
            @csrf
            
            <div class="mb-3">
                <label for="title" class="form-label">Judul Artikel / Thread</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title') }}" required>
            </div>
            
            <div class="mb-3">
                <label for="content" class="form-label">Isi Artikel / Thread</label>
                <textarea name="content" id="content" rows="6" class="form-control"
                        required>{{ old('content') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('forum.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</section>
@endsection
