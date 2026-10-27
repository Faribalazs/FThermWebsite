<?php

namespace Tests\Feature;

use App\Models\GalleryAlbum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryMediaTest extends TestCase
{
    use RefreshDatabase;

    private function album(array $attributes = []): GalleryAlbum
    {
        return GalleryAlbum::create(array_merge([
            'title' => ['sr' => 'Test referenca', 'en' => 'Test reference', 'hu' => 'Teszt referencia'],
            'slug' => 'test-reference', 'active' => true, 'order' => 0,
        ], $attributes));
    }

    private function admin(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true, 'role' => 'admin']), 'admin');
        Storage::fake('public');
    }

    public function test_admin_can_upload_a_video_with_a_safe_filename_and_delete_it(): void
    {
        $this->admin();
        $album = $this->album();
        // Real MP4 ftyp header: MIME detection must inspect content, not the client filename.
        $fixture = UploadedFile::fake()->createWithContent('video.mp4', pack('N', 24).'ftypisom'.pack('N', 0).'isommp42');
        $file = new UploadedFile($fixture->getPathname(), 'original camera name.mov', 'application/octet-stream', null, true);
        $this->post(route('admin.gallery.videos.upload', $album), ['video' => $file, 'video_caption' => 'Installation'])
            ->assertSessionHasNoErrors()->assertRedirect(route('admin.gallery.edit', $album));

        $video = $album->videos()->sole();
        $this->assertMatchesRegularExpression('#^gallery/'.$album->id.'/videos/[0-9a-f-]+\.mp4$#', $video->path);
        $this->assertSame('video/mp4', $video->mime_type);
        $this->assertSame('Installation', $video->caption);
        Storage::disk('public')->assertExists($video->path);
        $this->delete(route('admin.gallery.videos.delete', [$album, $video]))->assertRedirect();
        $this->assertModelMissing($video);
        Storage::disk('public')->assertMissing($video->path);
    }

    public function test_video_upload_rejects_disguised_files_and_files_over_50_mb(): void
    {
        $this->admin();
        $album = $this->album();
        $fixture = UploadedFile::fake()->createWithContent('bad.mp4', '<?php echo "not a video";');
        foreach ([
            new UploadedFile($fixture->getPathname(), 'bad.mp4', 'video/mp4', null, true),
            UploadedFile::fake()->create('large.mp4', 51201, 'video/mp4'),
        ] as $file) {
            $this->post(route('admin.gallery.videos.upload', $album), ['video' => $file])->assertSessionHasErrors('video');
        }
        $this->assertDatabaseCount('gallery_videos', 0);
        $this->assertEmpty(Storage::disk('public')->allFiles());
    }

    public function test_admin_can_upload_webm_using_its_detected_content_type(): void
    {
        $this->admin();
        $album = $this->album();
        $fixture = UploadedFile::fake()->createWithContent('video.webm', "\x1a\x45\xdf\xa3\x87\x42\x82\x84webm".str_repeat("\0", 64));
        $file = new UploadedFile($fixture->getPathname(), 'camera.webm', 'application/octet-stream', null, true);

        $this->post(route('admin.gallery.videos.upload', $album), ['video' => $file])->assertSessionHasNoErrors();
        $video = $album->videos()->sole();
        $this->assertSame('video/webm', $video->mime_type);
        $this->assertStringEndsWith('.webm', $video->path);
        Storage::disk('public')->assertExists($video->path);
    }

    public function test_video_routes_require_admin_access_and_scope_deletions_to_the_album(): void
    {
        Storage::fake('public');
        $album = $this->album();
        $other = $this->album(['slug' => 'other']);
        $video = $other->videos()->create(['path' => 'gallery/other.mp4', 'mime_type' => 'video/mp4']);
        Storage::disk('public')->put($video->path, 'video');
        $this->post(route('admin.gallery.videos.upload', $album))->assertRedirect(route('admin.login'));
        $this->delete(route('admin.gallery.videos.delete', [$other, $video]))->assertRedirect(route('admin.login'));
        $this->actingAs(User::factory()->create(['is_admin' => false, 'role' => 'worker']), 'admin');
        $this->post(route('admin.gallery.videos.upload', $album))->assertForbidden();
        $this->actingAs(User::factory()->create(['is_admin' => true, 'role' => 'admin']), 'admin');
        $this->delete(route('admin.gallery.videos.delete', [$album, $video]))->assertNotFound();
        $this->assertModelExists($video);
        Storage::disk('public')->assertExists($video->path);
    }

    public function test_deleting_a_reference_removes_its_videos_and_images(): void
    {
        $this->admin();
        $album = $this->album();
        $image = $album->images()->create(['path' => 'gallery/photo.webp']);
        $video = $album->videos()->create(['path' => 'gallery/video.webm', 'mime_type' => 'video/webm']);
        Storage::disk('public')->put($image->path, 'image');
        Storage::disk('public')->put($video->path, 'video');
        $this->delete(route('admin.gallery.destroy', $album))->assertRedirect();
        $this->assertModelMissing($album);
        $this->assertModelMissing($video);
        $this->assertModelMissing($image);
        Storage::disk('public')->assertMissing([$image->path, $video->path]);
    }

    public function test_public_references_display_videos_without_preloading_them_in_every_language(): void
    {
        $album = $this->album();
        $video = $album->videos()->create(['path' => 'gallery/video.webm', 'mime_type' => 'video/webm', 'caption' => 'Work video']);
        foreach (['sr', 'en', 'hu'] as $locale) {
            $this->get('/'.$locale.'/references')->assertOk()->assertSee($album->title[$locale]);
            $this->get('/'.$locale.'/references/'.$album->slug)->assertOk()
                ->assertSee('controls playsinline preload="none"', false)
                ->assertSee(Storage::url($video->path), false)->assertSee('Work video')
                ->assertDontSee('autoplay', false);
        }
        $album->update(['active' => false]);
        $this->get('/sr/references/'.$album->slug)->assertNotFound();
    }

    public function test_reference_images_go_through_the_shared_optimizer_and_admin_view_shows_both_uploads(): void
    {
        $this->admin();
        $album = $this->album();
        $this->post(route('admin.gallery.images.upload', $album), ['images' => [UploadedFile::fake()->image('photo.jpg', 3000, 2000)]])
            ->assertSessionHasNoErrors();
        $path = $album->images()->sole()->path;
        $info = getimagesizefromstring(Storage::disk('public')->get($path));
        $this->assertSame('image/webp', $info['mime']);
        $this->assertSame([2048, 1365], [$info[0], $info[1]]);
        $this->get(route('admin.gallery.edit', $album))->assertOk()->assertSee('Otpremi video')->assertSee('WebP');
        $this->get(route('admin.gallery.index'))->assertOk();
        $this->post(route('admin.gallery.images.upload', $album), ['images' => UploadedFile::fake()->image('single.png')])
            ->assertSessionHasErrors('images');
    }
}
