<?php

namespace App\Services\Image;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageResizeService implements ImageResizeServiceInterface
{
    protected $manager;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }

    public function resize(string $path, int $width, int $height): string
    {
        $image = $this->manager->read($path);
        
        $image->resize($width, $height, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });

        // Save as a new file or overwrite?
        // Let's create a new file specifically for resized version to avoid destruction
        $info = pathinfo($path);
        $newPath = $info['dirname'] . '/' . $info['filename'] . "_{$width}x{$height}." . $info['extension'];
        
        $image->save($newPath);

        return $newPath;
    }

    public function createThumbnail(string $path): string
    {
        return $this->resize($path, 150, 150);
    }
}
