<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApplyPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_open_apply_page(): void
    {
        $student = User::factory()->create([
            'username' => 'applystu',
            'role' => 'student',
            'is_active' => true,
        ]);

        Course::create([
            'name_bn' => 'টেস্ট কোর্স',
            'name_en' => 'Test Course',
            'level' => 'Level 2',
            'duration_bn' => '৩ মাস',
            'duration_en' => '3 months',
            'seats_total' => 40,
            'seats_available' => 40,
            'fee' => 0,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $response = $this->actingAs($student)->get(route('applications.create', ['course' => 1]));

        $response->assertOk();
        $response->assertSee('ভর্তির আবেদন', false);
    }

    public function test_admin_clicking_apply_redirects_with_error_not_server_error(): void
    {
        $admin = User::factory()->create([
            'username' => 'applyadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->get(route('applications.create', ['course' => 1]));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('error');
    }
}
