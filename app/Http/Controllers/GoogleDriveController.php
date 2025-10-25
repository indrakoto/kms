<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class GoogleDriveController extends Controller
{
    /**
     * Tampilkan halaman utama Google Drive dengan listing folder/file root
     */
    public function test()
    {
        //$path = ""; 
        $recursive = true;
        $filepath = 'me.jpg';
        $fileinfo = self::getFileInfo($filepath);

        $readStream = Storage::disk('google')->getDriver()->readStream($filepath);

        return (object) [
            'file' => $readStream,
            'ext' => $fileinfo->ext,
            'filename' => $fileinfo->filename,
        ];
        //$adapter = Storage::disk('google');
        //$contents = collect(Storage::disk('google')->listContents($path));

        //return $contents;

        //print_r($folders);
    }
    public static function getFileInfo($file_path)
    {
        $path = str_replace('\\', '/', $file_path);
        $arr = explode('/', $path);
        $file_name = end($arr);
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);

        return (object) [
            'filename' => $file_name,
            'ext' => $ext,
            'path' => $path,
        ];
    }

    public function indexXX($folderId = null)
    {
        return view('knowledges.drive.index', ['folderId' => $folderId]);
    }
    
    public function index()
    {
        return view('knowledges.drive.index');
    }

    /**
     * Tampilkan isi folder tertentu berdasarkan $folderId
     */
    public function showFolder($folderId)
    {
        $contents = $this->getFolderContents($folderId);
        return view('knowledges.drive.folder', [
            'folders' => $contents['folders'],
            'files' => $contents['files'],
            'currentFolderId' => $folderId,
        ]);

        // Berikan data folderId ke view (bisa juga untuk load data awal Livewire jika perlu)
        //return view('knowledges.drive.folder', compact('folderId'));
    }

    /**
     * Tampilkan preview file berdasarkan $fileId
     */
    public function viewFile($fileId)
    {
        // Ambil file metadata dari Google Drive
        $adapter = Storage::disk('google')->getAdapter();
        $service = $adapter->getService();

        try {
            $file = $service->files->get($fileId, ['fields' => 'id, name, mimeType, webContentLink, webViewLink']);
        } catch (\Exception $e) {
            abort(404, 'File tidak ditemukan atau akses gagal');
        }
        // Tampilkan view preview dengan data file
        return view('knowledges.drive.file_view', compact('file'));
    }


    // Fungsi untuk dapatkan folder dan file di folder tertentu dari Google Drive
    private function getFolderContents($folderId)
    {

        // pastikan $folderId tidak null atau kosong
        $folderId = $folderId ?: env('GOOGLE_DRIVE_FOLDER', '');

        $allFiles = Storage::disk('google')->listContents($folderId);

        //$flysystem = Storage::disk('google')->getDriver();

        //$allFiles = Storage::disk('google')->allDirectories(); // Dapatkan semua file/folder di dalam folder
        //->directories($folderId); // Dapatkan semua file/folder di dalam folder
        //->allDirectories(); ;
        
        //->listContents($folderId);
        

        $folders = [];
        $files = [];

        foreach ($allFiles as $file) {
            if ($file['type'] === 'dir') {
                $folders[] = $file;
            } else {
                $files[] = $file;
            }
        }

        return compact('folders', 'files');
    }

    // Fungsi untuk mendapat URL file Google Drive untuk preview/download akses langsung
    private function getFileUrl($fileId)
    {
        $disk = Storage::disk('google');
        // Dapatkan metadata file
        $files = $disk->listContents('/', true);
        foreach ($files as $file) {
            if ($file['type'] === 'file' && $file['path'] === $fileId) {
                // Biasanya file ID sama dengan path, Anda bisa sesuaikan mekanisme ini 
                // Jika membutuhkan token akses langsung ke file
                return $disk->url($file['path']);
            }
        }
        return null;
    }

    
    public function listContents()
    {
        try {
            $folderId = request('folderId');
            $contents = collect(Storage::disk('google')->listContents($folderId ?? '/'))
                ->map(function ($item) {
                    return [
                        'id' => $item['extra_metadata']['id'],
                        'name' => $item['extra_metadata']['name'],
                        'type' => $item['type'],
                        'icon' => $this->getFileIcon($item),
                        'modified' => date('Y-m-d H:i', $item['last_modified']),
                        'size' => isset($item['file_size']) ? $this->formatSize($item['file_size']) : null,
                        'mime' => $item['mime_type'] ?? null
                    ];
                });

            return response()->json($contents);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function preview($fileId)
    {
        try {
            $adapter = Storage::disk('google')->getAdapter();
            $file = $adapter->getMetadata($fileId);
            $mimeType = $file['mime_type'];
            $fileName = $file['extra_metadata']['name'];

            // Handle Google Workspace files
            if (str_contains($mimeType, 'google-apps')) {
                return $this->handleGoogleWorkspaceFile($fileId, $mimeType, $fileName);
            }

            // Handle images and PDFs
            if (str_starts_with($mimeType, 'image/') || $mimeType === 'application/pdf') {
                $content = Storage::disk('google')->get($fileId);
                
                return response($content)
                    ->header('Content-Type', $mimeType)
                    ->header('Content-Disposition', 'inline; filename="'.$fileName.'"');
            }

            // For other files, offer download
            return $this->download($fileId);

        } catch (\Exception $e) {
            abort(404, 'File not found');
        }
    }

    public function download($fileId)
    {
        $file = Storage::disk('google')->getAdapter()->getMetadata($fileId);
        $headers = [
            'Content-Type' => $file['mime_type'],
            'Content-Disposition' => 'attachment; filename="'.$file['extra_metadata']['name'].'"'
        ];

        return Storage::disk('google')->download($fileId, $file['extra_metadata']['name'], $headers);
    }

    private function handleGoogleWorkspaceFile($fileId, $mimeType, $fileName)
    {
        $client = Storage::disk('google')->getAdapter()->getService()->getClient();
        $service = new Drive($client);
        
        $exportMime = match(true) {
            str_contains($mimeType, 'document') => 'application/pdf',
            str_contains($mimeType, 'spreadsheet') => 'application/pdf',
            str_contains($mimeType, 'presentation') => 'application/pdf',
            default => 'application/pdf'
        };

        $response = $service->files->export($fileId, $exportMime, ['alt' => 'media']);

        return response($response->getBody()->getContents())
            ->header('Content-Type', $exportMime)
            ->header('Content-Disposition', 'inline; filename="'.pathinfo($fileName, PATHINFO_FILENAME).'.pdf"');
    }

    private function getFileIcon($item)
    {
        if ($item['type'] === 'dir') return '📁';
        
        $ext = pathinfo($item['extra_metadata']['name'], PATHINFO_EXTENSION);
        
        return match($ext) {
            'pdf' => '📄',
            'jpg', 'jpeg', 'png', 'gif', 'webp' => '🖼️',
            'doc', 'docx' => '📝',
            'xls', 'xlsx' => '📊',
            default => '📋'
        };
    }

    private function formatSize($bytes)
    {
        if ($bytes >= 1073741824) return round($bytes / 1073741824, 2) . ' GB';
        if ($bytes >= 1048576) return round($bytes / 1048576, 2) . ' MB';
        if ($bytes >= 1024) return round($bytes / 1024, 2) . ' KB';
        return $bytes . ' bytes';
    }

    public function checkAccess($folderId)
    {
        try {
            $folderId = request('folderId');
            
            // Dapatkan listing konten
            $listing = Storage::disk('google')->listContents($folderId ?? '/');
            
            // Konversi DirectoryListing ke array
            $contents = collect($listing->toArray())->map(function ($item) {
                return [
                    'id' => $item['extra_metadata']['id'],
                    'name' => $item['extra_metadata']['name'],
                    'type' => $item['type'],
                    'icon' => $this->getFileIcon($item),
                    'modified' => date('Y-m-d H:i', $item['last_modified']),
                    'size' => isset($item['file_size']) ? $this->formatSize($item['file_size']) : null,
                    'mime' => $item['mime_type'] ?? null
                ];
            });

            return response()->json($contents);

        } catch (\Exception $e) {
            \Log::error("Google Drive Error", [
                'folderId' => $folderId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'error' => 'Failed to access folder',
                'solution' => 'Please ensure the folder is shared with the service account'
            ], 403);
        }
    }

}