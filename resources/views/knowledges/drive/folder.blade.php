@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Google Drive - Folder Contents</h1>
    <p><a href="{{ route('knowledge.drive.index') }}">&larr; Back to Root Folder</a></p>

    @if(count($folders) > 0)
    <h3>Folders</h3>
    <ul>
        @foreach ($folders as $folder)
        <li>
            <a href="{{ route('knowledge.drive.folder', $folder['path']) }}">
                📁 {{ $folder['basename'] }}
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($files) > 0)
    <h3>Files</h3>
    <ul>
        @foreach ($files as $file)
        <li>
            <a href="{{ route('knowledge.drive.file.view', $file['path']) }}">
                📄 {{ $file['basename'] }}
            </a>
        </li>
        @endforeach
    </ul>
    @endif

    @if(count($folders) === 0 && count($files) === 0)
    <p>This folder is empty.</p>
    @endif
</div>
@endsection
