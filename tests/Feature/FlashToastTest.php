<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlashToastTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_staff_store_flashes_success_toast_on_redirect(): void
    {
        $admin = User::factory()->create([
            'username' => 'adminflash',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.staff.store'), [
            'name' => 'Test Officer',
            'designation' => 'Chairman',
            'is_active' => '1',
            'sort_order' => 1,
        ]);

        $response->assertRedirect(route('admin.staff.index'));
        $response->assertSessionHas('success');

        $follow = $this->actingAs($admin)->get(route('admin.staff.index'));
        $follow->assertOk();
        $follow->assertSee('flash-toast--success', false);
        $follow->assertSee('কর্তৃপক্ষ যোগ হয়েছে।', false);
        $this->assertDatabaseHas('staff', ['name' => 'Test Officer']);
    }

    public function test_validation_errors_render_error_toast(): void
    {
        $admin = User::factory()->create([
            'username' => 'adminflash2',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)
            ->from(route('admin.staff.create'))
            ->followingRedirects()
            ->post(route('admin.staff.store'), [
                'name' => '',
                'designation' => '',
            ]);

        $response->assertOk();
        $response->assertSee('flash-toast--error', false);
    }

    public function test_public_layout_shows_success_flash_toast(): void
    {
        $response = $this->withSession(['success' => 'টেস্ট সফল হয়েছে।'])->get(route('home'));

        $response->assertOk();
        $response->assertSee('flash-toast--success', false);
        $response->assertSee('টেস্ট সফল হয়েছে।', false);
    }
}
