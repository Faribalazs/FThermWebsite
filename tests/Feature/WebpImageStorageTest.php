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
}
