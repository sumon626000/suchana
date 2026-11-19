<?php

namespace Tests\Feature;

use App\Models\Application;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_loads_and_legacy_admin_root_redirects(): void
    {
        $admin = User::factory()->create([
            'username' => 'dashadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'username' => 'dashstudent',
            'role' => 'student',
            'is_active' => true,
        ]);

        $course = Course::create([
            'name_bn' => 'জাপানিজ ভাষা',
            'name_en' => 'Japanese Language',
            'level' => 'Level 2',
            'seats_total' => 20,
            'seats_available' => 20,
            'fee' => 0,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        Application::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'application_no' => 'APP-TEST-1',
            'full_name' => 'Test Student',
            'nid' => '1234567890',
            'mobile' => '01700000000',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertOk();
        $response->assertSee('ড্যাশবোর্ড', false);
        $response->assertSee('Test Student', false);

        $legacy = $this->actingAs($admin)->get('/admin');
        $legacy->assertRedirect(route('admin.dashboard'));
    }
}
