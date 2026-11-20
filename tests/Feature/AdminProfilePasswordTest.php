<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminProfilePasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_change_own_password(): void
    {
        $admin = User::factory()->create([
            'username' => 'pwdadmin',
            'role' => 'admin',
            'is_active' => true,
            'password' => 'oldpass1',
        ]);

        $this->actingAs($admin)
            ->get(route('admin.profile.password.edit'))
            ->assertOk()
            ->assertSee('পাসওয়ার্ড পরিবর্তন', false);

        $response = $this->actingAs($admin)->post(route('admin.profile.password'), [
            'current_password' => 'oldpass1',
            'password' => 'newpass9',
            'password_confirmation' => 'newpass9',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $admin->refresh();
        $this->assertTrue(Hash::check('newpass9', $admin->password));
    }
}
