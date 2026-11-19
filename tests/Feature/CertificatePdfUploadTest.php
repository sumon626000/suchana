<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class CertificatePdfUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_certificate_with_uploaded_pdf(): void
    {
        $admin = User::factory()->create([
            'username' => 'certadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'username' => 'certstudent',
            'role' => 'student',
            'is_active' => true,
            'name' => 'Shipa Begum',
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

        $pdf = UploadedFile::fake()->create('Certificate_SHIPA_BEGUM.pdf', 120, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('admin.certificates.store'), [
            'user_id' => $student->id,
            'course_id' => $course->id,
            'pdf_file' => $pdf,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $certificate = Certificate::first();
        $this->assertNotNull($certificate);
        $this->assertTrue($certificate->hasUploadedPdf());

        $download = $this->get(route('certificate.pdf', $certificate->certificate_no));
        $download->assertOk();
        $download->assertHeader('content-type', 'application/pdf');

        File::delete($certificate->pdfPublicPath());
    }

    public function test_admin_can_upload_pdf_to_existing_certificate(): void
    {
        $admin = User::factory()->create([
            'username' => 'certadmin2',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'username' => 'certstudent2',
            'role' => 'student',
            'is_active' => true,
        ]);

        $course = Course::create([
            'name_bn' => 'হাউজকিপিং',
            'name_en' => 'Housekeeping',
            'level' => 'Level 2',
            'duration_bn' => '৩ মাস',
            'duration_en' => '3 months',
            'seats_total' => 20,
            'seats_available' => 20,
            'fee' => 0,
            'is_active' => true,
            'sort_order' => 2,
        ]);

        $certificate = Certificate::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'certificate_no' => 'SUCHANA-CERT-2026-00099',
            'verification_code' => 'TESTCODE99',
            'issued_at' => now(),
            'issued_by' => $admin->id,
            'status' => 'issued',
        ]);

        $pdf = UploadedFile::fake()->create('nsc.pdf', 80, 'application/pdf');

        $response = $this->actingAs($admin)->post(route('admin.certificates.upload-pdf', $certificate), [
            'pdf_file' => $pdf,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $certificate->refresh();
        $this->assertTrue($certificate->hasUploadedPdf());

        File::delete($certificate->pdfPublicPath());
    }
}
