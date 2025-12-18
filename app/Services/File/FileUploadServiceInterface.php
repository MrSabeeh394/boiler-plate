<?php

namespace App\Services\File;

use Illuminate\Http\UploadedFile;

interface FileUploadServiceInterface
{
    /**
     * Upload a file to the specified path.
     *
     * @param  UploadedFile  $file
     * @param  string  $path
     * @param  string|null  $disk
     * @return array  Returns [path, url, size, mime_type]
     */
    public function upload(UploadedFile $file, string $path, ?string $disk = null): array;

    /**
     * Delete a file.
     *
     * @param  string  $path
     * @param  string|null  $disk
     * @return bool
     */
    public function delete(string $path, ?string $disk = null): bool;
}
