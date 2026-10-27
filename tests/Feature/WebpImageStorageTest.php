<?php

namespace Tests\Feature;

use App\Services\WebpImageStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WebpImageStorageTest extends TestCase
{
    public function test_it_converts_an_uploaded_image_to_webp(): void
    {
        Storage::fake('public');

        $path = app(WebpImageStorage::class)->store(
            UploadedFile::fake()->image('photo.png', 120, 80),
            'gallery/10'
        );

        $this->assertMatchesRegularExpression('#^gallery/10/[0-9a-f-]+\.webp$#', $path);
        Storage::disk('public')->assertExists($path);

        $imageInfo = getimagesizefromstring(Storage::disk('public')->get($path));

        $this->assertIsArray($imageInfo);
        $this->assertSame('image/webp', $imageInfo['mime']);
        $this->assertSame(120, $imageInfo[0]);
        $this->assertSame(80, $imageInfo[1]);
    }

    public function test_it_reduces_large_images_without_changing_their_aspect_ratio(): void
    {
        Storage::fake('public');
        $file = UploadedFile::fake()->image('large.png', 3200, 2400);
        $path = app(WebpImageStorage::class)->store($file, 'services');
        $contents = Storage::disk('public')->get($path);
        $info = getimagesizefromstring($contents);

        $this->assertSame([2048, 1536], [$info[0], $info[1]]);
        $this->assertLessThan(filesize($file->getRealPath()), strlen($contents));
    }

    public function test_it_keeps_transparency_when_resizing(): void
    {
        Storage::fake('public');
        $image = imagecreatetruecolor(2400, 1200);
        imagealphablending($image, false);
        imagesavealpha($image, true);
        imagefill($image, 0, 0, imagecolorallocatealpha($image, 0, 0, 0, 127));
        imagefilledrectangle($image, 800, 400, 1600, 800, imagecolorallocatealpha($image, 230, 40, 20, 0));
        ob_start();
        imagepng($image);
        $png = ob_get_clean();
        imagedestroy($image);

        $path = app(WebpImageStorage::class)->store(UploadedFile::fake()->createWithContent('logo.png', $png), 'slides');
        $result = imagecreatefromstring(Storage::disk('public')->get($path));
        $this->assertSame(127, imagecolorsforindex($result, imagecolorat($result, 0, 0))['alpha']);
        $this->assertSame(0, imagecolorsforindex($result, imagecolorat($result, 1024, 512))['alpha']);
        imagedestroy($result);
    }

    public function test_it_applies_all_phone_exif_orientations_and_removes_metadata(): void
    {
        if (! function_exists('exif_read_data')) {
            $this->markTestSkipped('EXIF extension required.');
        }
        Storage::fake('public');
        $image = imagecreatetruecolor(120, 80);
        imagefilledrectangle($image, 0, 0, 59, 79, imagecolorallocate($image, 255, 0, 0));
        imagefilledrectangle($image, 60, 0, 119, 79, imagecolorallocate($image, 0, 0, 255));
        ob_start();
        imagejpeg($image, null, 95);
        $jpeg = ob_get_clean();
        imagedestroy($image);

        foreach (range(1, 8) as $orientation) {
            // A minimal little-endian EXIF IFD0 with the standard Orientation tag.
            $exif = "Exif\0\0II\x2a\0\x08\0\0\0\x01\0\x12\x01\x03\0\x01\0\0\0"
                .pack('v', $orientation)."\0\0\0\0\0\0";
            $oriented = substr($jpeg, 0, 2)."\xff\xe1".pack('n', strlen($exif) + 2).$exif.substr($jpeg, 2);
            $path = app(WebpImageStorage::class)->store(UploadedFile::fake()->createWithContent('phone.jpg', $oriented), 'gallery');
            $contents = Storage::disk('public')->get($path);
            $result = imagecreatefromstring($contents);
            $this->assertSame($orientation >= 5 ? 80 : 120, imagesx($result));
            $this->assertSame($orientation >= 5 ? 120 : 80, imagesy($result));
            $corner = imagecolorsforindex($result, imagecolorat($result, 10, 10));
            $redAtTopLeft = in_array($orientation, [1, 4, 5, 6], true);
            $this->assertGreaterThan(240, $corner[$redAtTopLeft ? 'red' : 'blue'], 'Orientation '.$orientation);
            $this->assertStringNotContainsString('Exif', $contents);
            imagedestroy($result);
        }
    }
}
