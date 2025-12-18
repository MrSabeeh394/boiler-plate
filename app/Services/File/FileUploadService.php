<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService implements FileUploadServiceInterface
{
    public function upload(UploadedFile $file, string $path, ?string $disk = null): array
    {
        $disk = $disk ?? config('filesystems.default');
        
        $filename = $file->hashName();
        $storedPath = $file->storeAs($path, $filename, $disk);

        return [
            'path' => $storedPath,
            'url' => Storage::disk($disk)->url($storedPath),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }

    public function delete(string $path, ?string $disk = null): bool
    {
        $disk = $disk ?? config('filesystems.default');
        return Storage::disk($disk)->delete($path);
    }
}
