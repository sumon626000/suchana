<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WhatsappLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_whatsapp_digits_normalize_bangladesh_local_numbers(): void
    {
        $this->assertSame('8801615723623', Settings::whatsappDigits('01615723623'));
        $this->assertSame('8801615723623', Settings::whatsappDigits('+880 1615-723623'));
        $this->assertSame('8801615723623', Settings::whatsappDigits('https://wa.me/01615723623'));
        $this->assertSame('8801615723623', Settings::whatsappDigits('8801615723623'));
    }

    public function test_absolute_url_adds_https_when_missing(): void
    {
        $this->assertSame('https://facebook.com/page', Settings::absoluteUrl('facebook.com/page'));
        $this->assertSame('https://www.facebook.com/share/1CLAgRx2Cq/', Settings::absoluteUrl('https://www.facebook.com/share/1CLAgRx2Cq/'));
        $this->assertSame('', Settings::absoluteUrl(''));
    }

    public function test_admin_save_normalizes_whatsapp_and_facebook(): void
    {
        $admin = User::factory()->create([
            'username' => 'socialadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), [
            'site_name' => 'Suchana',
            'site_name_bn' => 'সুচনা',
            'theme_color' => 'sky',
            'whatsapp_number' => '01615723623',
            'facebook_url' => 'facebook.com/suchana',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertSame('8801615723623', Setting::where('key', 'whatsapp_number')->value('value'));
        $this->assertSame('https://facebook.com/suchana', Setting::where('key', 'facebook_url')->value('value'));

        Settings::flush();

        $home = $this->get(route('home'));
        $home->assertOk();
        $home->assertSee('https://wa.me/8801615723623', false);
        $home->assertSee('https://facebook.com/suchana', false);
        $home->assertDontSee('https://wa.me/01615723623', false);
    }
}
