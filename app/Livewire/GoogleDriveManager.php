<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Google\Client;
use Google\Service\Drive;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class GoogleDriveManager extends Component
{
    use WithFileUploads;

    public $currentFolderId = 'root';  // default folder root Google Drive
    public $files = [];
    public $folders = [];
    public $searchTerm = '';
    public $uploadFile;
    public $uploadProgress = 0;

    protected $listeners = [
        'refreshFiles' => 'loadFiles'
    ];

    public function mount($folderId = 'root')
    {
        $this->currentFolderId = $folderId;
        $this->loadFiles();
    }
    public function render()
    {
        return view('livewire.google-drive-manager');
    }
    public function loadFiles()
    {
        // Ambil daftar file dan folder dari folder saat ini
        $adapter = Storage::disk('google')->getAdapter();
        $service = $adapter->getService();

        $query = sprintf("'%s' in parents and trashed = false", $this->currentFolderId);
        if (!empty($this->searchTerm)) {
            $query .= " and name contains '{$this->searchTerm}'";
        }

        $params = [
            'q' => $query,
            'fields' => 'files(id, name, mimeType, size, modifiedTime)',
            'orderBy' => 'folder,name',
        ];

        try {
            $response = $service->files->listFiles($params);
            $items = $response->getFiles();

            $this->folders = [];
            $this->files = [];

            foreach ($items as $item) {
                if ($item->getMimeType() === 'application/vnd.google-apps.folder') {
                    $this->folders[] = $item;
                } else {
                    $this->files[] = $item;
                }
            }
        } catch (\Exception $e) {
            $this->folders = [];
            $this->files = [];
            session()->flash('error', 'Gagal memuat data folder/file: ' . $e->getMessage());
        }
    }

    public function updatedSearchTerm()
    {
        $this->loadFiles();
    }

    public function setFolder($folderId)
    {
        $this->currentFolderId = $folderId;
        $this->loadFiles();
    }

    public function upload()
    {
        $this->validate([
            'uploadFile' => 'required|file|max:10240', // max 10MB contoh
        ]);

        $adapter = Storage::disk('google')->getAdapter();
        $service = $adapter->getService();

        $client = $service->getClient();

        $filePath = $this->uploadFile->getRealPath();
        $fileName = $this->uploadFile->getClientOriginalName();

        $fileMetadata = new \Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'parents' => [$this->currentFolderId]
        ]);

        try {
            $content = file_get_contents($filePath);

            $createdFile = $service->files->create($fileMetadata, [
                'data' => $content,
                'mimeType' => $this->uploadFile->getMimeType(),
                'uploadType' => 'multipart',
                'fields' => 'id, name'
            ]);

            session()->flash('success', 'File berhasil diupload: ' . $createdFile->getName());
            $this->uploadFile = null;
            $this->loadFiles();

        } catch (\Exception $e) {
            session()->flash('error', 'Upload gagal: ' . $e->getMessage());
        }
    }




    public function download($fileId, $fileName)
    {
        $client = $this->driveService->getClient();

        // Dapatkan konten file
        $response = $this->driveService->files->get($fileId, ['alt' => 'media']);

        return response($response->getBody()->getContents(), 200)
            ->header('Content-Type', 'application/octet-stream')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }


}
