<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Drive\DriveFile;

class DriveUpload extends Component
{
    use WithFileUploads;

    public $uploadingFile;
    public $uploadProgress = 0;
    public $searchTerm = '';

    public function upload()
    {
        $this->validate([
            'uploadingFile' => 'required|file|max:10240', // max 10MB
        ]);

        $client = new Client();
        $client->setClientId(env('GOOGLE_DRIVE_CLIENT_ID'));
        $client->setClientSecret(env('GOOGLE_DRIVE_CLIENT_SECRET'));
        $client->refreshToken(env('GOOGLE_DRIVE_REFRESH_TOKEN'));
        $client->fetchAccessTokenWithRefreshToken();

        $drive = new Drive($client);

        $filePath = $this->uploadingFile->getRealPath();
        $fileName = $this->uploadingFile->getClientOriginalName();
        $mimeType = $this->uploadingFile->getMimeType();

        $fileMetadata = new DriveFile([
            'name' => $fileName,
        ]);

        // Upload file ke Google Drive dengan progress bar
        $content = fopen($filePath, 'r');

        $createdFile = null;
        // Gunakan resumable upload untuk progress (optional)
        $chunkSizeBytes = 1 * 1024 * 1024; // 1MB chunk
        $client->setDefer(true);
        $request = $drive->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'resumable',
        ]);
        $status = false;
        $uploadSessionUri = $request->getHeader('Location')[0] ?? null;

        if (!$uploadSessionUri) {
            // fallback upload simple
            $createdFile = $drive->files->create($fileMetadata, [
                'data' => file_get_contents($filePath),
                'mimeType' => $mimeType,
                'uploadType' => 'multipart',
                'fields' => 'id',
            ]);
            $this->uploadProgress = 100;
            $client->setDefer(false);
            $this->emit('fileUploaded');
            return;
        }

        $handle = fopen($filePath, "rb");
        $fileSize = filesize($filePath);
        $bytesUploaded = 0;

        while (!feof($handle)) {
            $chunk = fread($handle, $chunkSizeBytes);
            $chunkLength = strlen($chunk);

            $headers = [
                'Content-Length' => $chunkLength,
                'Content-Range' => "bytes $bytesUploaded-" . ($bytesUploaded + $chunkLength - 1) . "/" . $fileSize,
            ];

            // Kirim chunk pakai curl langsung
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uploadSessionUri);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Content-Length: $chunkLength",
                "Content-Range: bytes $bytesUploaded-".($bytesUploaded+$chunkLength-1)."/$fileSize",
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $chunk);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($statusCode == 308 /* Resume Incomplete */) {
                $bytesUploaded += $chunkLength;
                $this->uploadProgress = intval(($bytesUploaded / $fileSize) * 100);
                $this->emit('progressUpdated', $this->uploadProgress);
            } elseif ($statusCode >= 200 && $statusCode < 300) {
                // Upload selesai
                $this->uploadProgress = 100;
                $this->emit('progressUpdated', $this->uploadProgress);
                break;
            } else {
                // Error
                $this->dispatchBrowserEvent('uploadError', ['message' => 'Upload failed with status ' . $statusCode]);
                break;
            }
        }

        fclose($handle);

        $client->setDefer(false);

        $this->emit('fileUploaded');
    }

    public function render()
    {
        return view('livewire.drive-upload', [
            'searchTerm' => $this->searchTerm,
        ]);
    }
}
