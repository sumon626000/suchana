<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class HeroImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_separate_hero_slider_images(): void
    {
        $admin = User::factory()->create([
            'username' => 'heroadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file1 = UploadedFile::fake()->image('hero-1.jpg', 1200, 800);
        $file2 = UploadedFile::fake()->image('hero-2.jpg', 1200, 800);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'Suchana',
            'site_name_bn' => 'সুচনা',
            'theme_color' => 'sky',
            'hero_image_file' => [
                1 => $file1,
                2 => $file2,
            ],
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $path1 = Setting::where('key', 'hero_image_1')->value('value');
        $path2 = Setting::where('key', 'hero_image_2')->value('value');
        $this->assertNotEmpty($path1);
        $this->assertNotEmpty($path2);
        $this->assertStringStartsWith('uploads/home/', $path1);
        $this->assertStringStartsWith('uploads/home/', $path2);
        $this->assertFileExists(public_path($path1));
        $this->assertFileExists(public_path($path2));

        Settings::flush();

        $home = $this->get(route('home'));
        $home->assertOk();
        $home->assertSee('data-hero-slider', false);
        $home->assertSee('data-interval="5000"', false);
        $home->assertSee('/uploads/home/', false);
        $home->assertSee('data-hero-dot="1"', false);

        File::delete(public_path($path1));
        File::delete(public_path($path2));
    }

    public function test_admin_can_bulk_upload_five_hero_images(): void
    {
        $admin = User::factory()->create([
            'username' => 'herobulk',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $files = [];
        for ($i = 1; $i <= 5; $i++) {
            $files[] = UploadedFile::fake()->image("bulk-{$i}.jpg", 1000, 700);
        }

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'Suchana',
            'site_name_bn' => 'সুচনা',
            'theme_color' => 'sky',
            'hero_images_bulk' => $files,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $paths = [];
        for ($slot = 1; $slot <= 5; $slot++) {
            $path = Setting::where('key', 'hero_image_'.$slot)->value('value');
            $this->assertNotEmpty($path, "hero_image_{$slot} should be set");
            $this->assertFileExists(public_path($path));
            $paths[] = $path;
        }

        Settings::flush();

        $home = $this->get(route('home'));
        $home->assertOk();
        $home->assertSee('data-hero-dot="4"', false);

        foreach ($paths as $path) {
            File::delete(public_path($path));
        }
    }
}
