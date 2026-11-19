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

    public function test_admin_can_upload_home_hero_image(): void
    {
        $admin = User::factory()->create([
            'username' => 'heroadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('hero-banner.jpg', 1200, 800);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'Suchana',
            'site_name_bn' => 'সুচনা',
            'theme_color' => 'sky',
            'hero_image_file' => $file,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $path = Setting::where('key', 'hero_image')->value('value');
        $this->assertNotNull($path);
        $this->assertStringStartsWith('uploads/home/', $path);
        $this->assertFileExists(public_path($path));

        Settings::flush();

        $home = $this->get(route('home'));
        $home->assertOk();
        $home->assertSee('/uploads/home/', false);

        File::delete(public_path($path));
    }
}
