<?php
namespace App\Filament\Components;

use Filament\Forms\Components\FileUpload;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class ThumbnailUpload extends FileUpload
{
    public function handleUpload($file, $storagePath)
    {
        // Validasi ukuran minimal
        $image = Image::make($file);
        if ($image->width() < 704 || $image->height() < 412) {
            throw new \Exception('Ukuran gambar minimal 704x412 piksel');
        }

        // Resize dan simpan gambar
        $resizedImage = $image->fit(704, 412);
        $filename = uniqid().'.'.$file->getClientOriginalExtension();
        
        Storage::disk($this->getDiskName())->put(
            $storagePath.'/'.$filename,
            $resizedImage->encode()
        );

        return $filename;
    }
}