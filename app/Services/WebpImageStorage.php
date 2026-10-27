<?php

namespace App\Services;

use GdImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RuntimeException;

class WebpImageStorage
{
    public const MAX_DIMENSION = 2048;

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

            // Keep the full composition, but never send camera-sized originals to the browser.
            $width = imagesx($image);
            $height = imagesy($image);
            $scale = min(1, self::MAX_DIMENSION / max($width, $height));

            if ($scale < 1) {
                $newWidth = max(1, (int) round($width * $scale));
                $newHeight = max(1, (int) round($height * $scale));
                $resized = imagecreatetruecolor($newWidth, $newHeight);
                imagealphablending($resized, false);
                imagesavealpha($resized, true);
                imagecopyresampled($resized, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
                imagedestroy($image);
                $image = $resized;
            }

            // Apply phone-camera orientation before discarding EXIF metadata.
            $orientation = 1;
            if ($file->getMimeType() === 'image/jpeg' && function_exists('exif_read_data')) {
                $exif = @exif_read_data($file->getRealPath(), 'IFD0');
                $orientation = (int) ($exif['Orientation'] ?? 1);
            }
            $image = $this->orient($image, $orientation);

            ob_start();
            try {
                $encoded = imagewebp($image, null, $quality);
                $webp = ob_get_contents();
            } finally {
                ob_end_clean();
            }
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

    private function orient(GdImage $image, int $orientation): GdImage
    {
        if (in_array($orientation, [2, 5, 7], true)) {
            imageflip($image, IMG_FLIP_HORIZONTAL);
        } elseif ($orientation === 4) {
            imageflip($image, IMG_FLIP_VERTICAL);
        }

        $angle = match ($orientation) {
            3 => 180,
            5, 8 => 90,
            6, 7 => -90,
            default => 0,
        };

        if ($angle !== 0) {
            $rotated = imagerotate($image, $angle, 0);
            if ($rotated === false) {
                throw new RuntimeException('The uploaded image could not be rotated.');
            }
            imagedestroy($image);

            return $rotated;
        }

        return $image;
    }
}
