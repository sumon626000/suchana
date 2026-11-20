<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class LogoUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_logos_to_public_uploads(): void
    {
        $admin = User::factory()->create([
            'username' => 'logoadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $suchana = UploadedFile::fake()->image('suchana-logo.png', 400, 400);
        $sfdb = UploadedFile::fake()->image('sfdb-logo.jpg', 600, 300);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'Suchana',
            'site_name_bn' => 'সুচনা',
            'theme_color' => 'sky',
            'logo_suchana_file' => $suchana,
            'logo_sfdb_file' => $sfdb,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $path1 = Setting::where('key', 'logo_suchana')->value('value');
        $path2 = Setting::where('key', 'logo_sfdb')->value('value');

        $this->assertNotEmpty($path1);
        $this->assertNotEmpty($path2);
        $this->assertStringStartsWith('uploads/branding/', $path1);
        $this->assertStringStartsWith('uploads/branding/', $path2);
        $this->assertFileExists(public_path($path1));
        $this->assertFileExists(public_path($path2));

        Settings::flush();

        $home = $this->get(route('home'));
        $home->assertOk();
        $home->assertSee('/uploads/branding/', false);
        $home->assertDontSee('/storage/branding/', false);

        File::delete(public_path($path1));
        File::delete(public_path($path2));
    }
}
