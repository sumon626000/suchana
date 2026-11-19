<?php

namespace Tests\Feature;

use App\Models\Setting;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomeTextSettingsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_home_page_texts_and_home_shows_them(): void
    {
        $admin = User::factory()->create([
            'username' => 'settingadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $payload = [
            'site_name' => 'Suchana',
            'site_name_bn' => 'সুচনা',
            'theme_color' => 'sky',
            'brand_title_bn' => 'টেস্ট ব্র্যান্ড টাইটেল',
            'brand_title_en' => 'Test Brand Title',
            'hero_title_line1_bn' => 'টেস্ট হিরো লাইন ১',
            'hero_title_line1_en' => 'Test Hero Line 1',
            'hero_title_line2_bn' => 'টেস্ট হিরো লাইন ২',
            'hero_title_line2_en' => 'Test Hero Line 2',
            'hero_subtitle_bn' => 'টেস্ট হিরো সাবটাইটেল',
            'hero_subtitle_en' => 'Test hero subtitle',
            'home_running_title_bn' => 'টেস্ট চলমান কোর্স',
            'home_running_title_en' => 'Test Running',
            'home_courses_title_bn' => 'টেস্ট আমাদের কোর্স',
            'home_courses_title_en' => 'Test Courses',
        ];

        $response = $this->actingAs($admin)->post(route('admin.settings.update'), $payload);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->assertSame('টেস্ট ব্র্যান্ড টাইটেল', Setting::where('key', 'brand_title_bn')->value('value'));

        Settings::flush();

        $home = $this->get(route('home'));
        $home->assertOk();
        $home->assertSee('টেস্ট ব্র্যান্ড টাইটেল', false);
        $home->assertSee('টেস্ট হিরো লাইন ১', false);
        $home->assertSee('টেস্ট চলমান কোর্স', false);
        $home->assertSee('টেস্ট আমাদের কোর্স', false);
    }
}
