<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelSeparationTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_login_rejects_admin_accounts(): void
    {
        $admin = User::factory()->create([
            'username' => 'onlyadmin',
            'role' => 'admin',
            'is_active' => true,
            'password' => 'secret123',
        ]);

        $response = $this->post(route('login'), [
            'login' => $admin->username,
            'password' => 'secret123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_admin_login_rejects_students(): void
    {
        $student = User::factory()->create([
            'username' => 'plainstudent',
            'role' => 'student',
            'is_active' => true,
            'password' => 'secret123',
        ]);

        $response = $this->post(route('admin.login'), [
            'login' => $student->username,
            'password' => 'secret123',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasErrors('login');
        $this->assertGuest();
    }

    public function test_student_cannot_open_admin_panel(): void
    {
        $student = User::factory()->create([
            'username' => 'blockedstudent',
            'role' => 'student',
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->get(route('admin.dashboard'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error');
    }

    public function test_admin_user_panel_links_stay_on_public_site(): void
    {
        $admin = User::factory()->create([
            'username' => 'nojumpadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('applications.create'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error');
        $response->assertSessionMissing('intended');
    }

    public function test_admin_login_lands_on_admin_dashboard(): void
    {
        $admin = User::factory()->create([
            'username' => 'paneladmin',
            'role' => 'admin',
            'is_active' => true,
            'password' => 'secret123',
        ]);

        $response = $this->post(route('admin.login'), [
            'login' => $admin->username,
            'password' => 'secret123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_public_site_shows_admin_panel_label_not_student_dashboard_for_admin(): void
    {
        $admin = User::factory()->create([
            'username' => 'siteadmin',
            'name' => 'System Admin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('home'));

        $response->assertOk();
        $response->assertSee('অ্যাডমিন প্যানেল', false);
        $response->assertSee(route('admin.dashboard'), false);
        $response->assertDontSee('>আমার ড্যাশবোর্ড<', false);
        $response->assertDontSee(route('student.dashboard'), false);
    }

    public function test_student_public_menu_uses_student_dashboard(): void
    {
        $student = User::factory()->create([
            'username' => 'menustudent',
            'role' => 'student',
            'is_active' => true,
        ]);

        $response = $this->actingAs($student)->get(route('home'));

        $response->assertOk();
        $response->assertSee('আমার ড্যাশবোর্ড', false);
        $response->assertSee(route('student.dashboard'), false);
        $response->assertDontSee(route('admin.dashboard'), false);
    }
}
