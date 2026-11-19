<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateGeneratedPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_certificate_pdf_downloads_with_site_design_markup(): void
    {
        $admin = User::factory()->create([
            'username' => 'pdfadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'username' => 'pdfstudent',
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
            'certificate_no' => 'SUCHANA-CERT-2026-00001',
            'verification_code' => '42485CU5KZ',
            'issued_at' => now(),
            'issued_by' => $admin->id,
            'status' => 'issued',
        ]);

        $html = view('certificates.pdf', [
            'certificate' => $certificate->load(['user', 'course']),
            'logo1' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
            'logo2' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
            'qr' => 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==',
            'verifyUrl' => route('verify.code', $certificate->certificate_no),
        ])->render();

        $this->assertStringContainsString('#0a7a4b', $html);
        $this->assertStringContainsString('#c9a227', $html);
        $this->assertStringContainsString('CERTIFICATE OF COMPLETION', $html);
        $this->assertStringContainsString('Amran', $html);
        $this->assertStringContainsString('জাপানিজ ভাষা', $html);
        $this->assertStringContainsString('www.suchana.org', $html);

        $response = $this->get(route('certificate.pdf', $certificate->certificate_no));
        $response->assertOk();
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }
}
