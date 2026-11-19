<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateActionButtonsTest extends TestCase
{
    use RefreshDatabase;

    public function test_certificate_show_page_has_pdf_print_and_verify_buttons(): void
    {
        $admin = User::factory()->create([
            'username' => 'btnadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'username' => 'btnstudent',
            'role' => 'student',
            'is_active' => true,
            'name' => 'Amran',
        ]);

        $course = Course::create([
            'name_bn' => 'জাপানিজ ভাষা',
            'name_en' => 'Japanese Language',
            'level' => 'Level 2',
            'duration_bn' => '৩ মাস',
            'duration_en' => '3 months',
            'seats_total' => 30,
            'seats_available' => 30,
            'fee' => 0,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $certificate = Certificate::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'certificate_no' => 'SUCHANA-CERT-2026-00042',
            'verification_code' => '42485CU5KZ',
            'issued_at' => now(),
            'issued_by' => $admin->id,
            'status' => 'issued',
        ]);

        $response = $this->get(route('certificate.show', $certificate->certificate_no));
        $response->assertOk();
        $response->assertSee('PDF ডাউনলোড', false);
        $response->assertSee('প্রিন্ট', false);
        $response->assertSee('যাচাই করুন', false);
        $response->assertSee(route('certificate.pdf', $certificate->certificate_no), false);
        $response->assertSee(route('verify.code', $certificate->certificate_no), false);
    }
}
