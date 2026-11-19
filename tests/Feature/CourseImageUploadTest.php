<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CourseImageUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_course_image(): void
    {
        $admin = User::factory()->create([
            'username' => 'courseadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->image('english-course.jpg', 800, 450);

        $response = $this->actingAs($admin)->post(route('admin.courses.store'), [
            'name_bn' => 'ইংলিশ ফর ওয়ার্ক',
            'name_en' => 'English for Work',
            'level' => 'Level 2',
            'duration_bn' => '২১ দিন',
            'duration_en' => '21 Days',
            'seats_total' => 40,
            'seats_available' => 40,
            'fee' => 0,
            'stipend_male' => 4500,
            'stipend_female' => 6000,
            'is_active' => '1',
            'sort_order' => 1,
            'image_file' => $file,
        ]);

        $response->assertRedirect(route('admin.courses.index'));
        $response->assertSessionHas('success');

        $course = Course::first();
        $this->assertNotNull($course);
        $this->assertNotNull($course->image);
        $this->assertStringStartsWith('uploads/courses/', $course->image);
        $this->assertFileExists(public_path($course->image));
        $this->assertStringContainsString('/uploads/courses/', $course->imageUrl());

        File::delete(public_path($course->image));
    }
}
