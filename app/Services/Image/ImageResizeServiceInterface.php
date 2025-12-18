<?php

namespace App\Services\Image;

interface ImageResizeServiceInterface
{
    /**
     * Resize an image to the specified dimensions.
     *
     * @param  string  $path  Absolute path to the image
     * @param  int  $width
     * @param  int  $height
     * @return string  Path to the resized image
     */
    public function resize(string $path, int $width, int $height): string;

    /**
     * Create a thumbnail based on preset dimensions.
     *
     * @param  string  $path
     * @return string
     */
    public function createThumbnail(string $path): string;
}
