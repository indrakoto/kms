@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Preview File</h1>
    <p><a href="{{ url()->previous() }}">&larr; Back</a></p>

    @if($fileUrl)
    {{-- Embed file preview (PDF/Image) or link download --}}
    <iframe src="{{ $fileUrl }}" frameborder="0" width="100%" height="600px"></iframe>
    
    <p>
        <a href="{{ $fileUrl }}" download target="_blank" rel="noopener">
            Download File
        </a>
    </p>
    @else
    <p>File not available for preview.</p>
    @endif
    
</div>
@endsection
