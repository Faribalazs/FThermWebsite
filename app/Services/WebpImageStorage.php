<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class WebpImageStorage
{
    public function store(UploadedFile $file, string $directory, string $disk = 'public', int $quality = 82): string
    {
        if (! extension_loaded('gd') || ! function_exists('imagewebp')) {
            throw new RuntimeException('WebP image uploads require PHP GD with WebP support.');
        }

        $contents = file_get_contents($file->getRealPath());
        $image = $contents === false ? false : @imagecreatefromstring($contents);

        if ($image === false) {
            throw new RuntimeException('The uploaded image could not be decoded.');
        }

        try {
            if (! imageistruecolor($image)) {
                imagepalettetotruecolor($image);
            }

            imagealphablending($image, true);
            imagesavealpha($image, true);

            ob_start();
            $encoded = imagewebp($image, null, $quality);
            $webp = ob_get_clean();
        } finally {
            imagedestroy($image);
        }

        if (! $encoded || ! is_string($webp) || $webp === '') {
            throw new RuntimeException('The uploaded image could not be converted to WebP.');
        }

        $path = trim($directory, '/').'/'.Str::uuid().'.webp';

        if (! Storage::disk($disk)->put($path, $webp)) {
            throw new RuntimeException('The converted image could not be stored.');
        }

        return $path;
    }
}
