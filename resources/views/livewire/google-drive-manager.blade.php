<div>
    <div class="mb-3">
        <input type="text" wire:model.debounce.500ms="searchTerm" placeholder="Cari folder/file..." class="form-control" />
    </div>

    <div class="mb-3">
        <input type="file" wire:model="uploadFile" />
        @error('uploadFile') <span class="text-danger">{{ $message }}</span> @enderror
        <button wire:click="upload" class="btn btn-primary btn-sm" @if(!$uploadFile) disabled @endif>Upload</button>
    </div>

    <div>
        <h5>Folders</h5>
        <ul>
            @foreach($folders as $folder)
            <li>
                <a href="javascript:void(0)" wire:click.prevent="setFolder('{{ $folder->getId() }}')">
                    📁 {{ $folder->getName() }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>

    <div>
        <h5>Files</h5>
        <ul>
            @foreach($files as $file)
            <li>
                <a href="{{ route('knowledge.drive.file.view', $file->getId()) }}" target="_blank">
                    📄 {{ $file->getName() }}
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>
