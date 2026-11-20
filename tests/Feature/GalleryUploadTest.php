<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\ShowcaseCertificate;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class GalleryUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_gallery_image_to_public_uploads(): void
    {
        $admin = User::factory()->create([
            'username' => 'galadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('campus.png', 800, 600);

        $response = $this->actingAs($admin)->post(route('admin.gallery.store'), [
            'title_bn' => 'ক্যাম্পাস',
            'title_en' => 'Campus',
            'image' => $file,
            'sort_order' => 1,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('gallery', ['title_bn' => 'ক্যাম্পাস']);
        $path = Gallery::first()->image;
        $this->assertStringStartsWith('uploads/gallery/', $path);
        $this->assertFileExists(public_path($path));

        Settings::flush();
        $home = $this->get(route('home'));
        $home->assertOk();
        $home->assertSee('/uploads/gallery/', false);

        File::delete(public_path($path));
    }

    public function test_admin_can_upload_showcase_certificate_image(): void
    {
        $admin = User::factory()->create([
            'username' => 'showadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('cert.jpg', 1000, 700);

        $response = $this->actingAs($admin)->post(route('admin.showcase-certificates.store'), [
            'title_bn' => 'নমুনা সনদ',
            'image' => $file,
            'sort_order' => 0,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.showcase-certificates.index'));
        $path = ShowcaseCertificate::first()->image;
        $this->assertStringStartsWith('uploads/showcase-certificates/', $path);
        $this->assertFileExists(public_path($path));
        File::delete(public_path($path));
    }
}
