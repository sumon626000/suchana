<?php

namespace Tests\Feature;

use App\Mail\SiteMessageMail;
use App\Models\Application;
use App\Models\Course;
use App\Models\Setting;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class TransactionalMailTest extends TestCase
{
    use RefreshDatabase;

    public function test_application_submission_emails_student_and_admin(): void
    {
        Mail::fake();

        Setting::updateOrCreate(['key' => 'email'], ['value' => 'help@suchana.bd']);
        Settings::flush();

        $student = User::factory()->create([
            'username' => 'mailstu',
            'role' => 'student',
            'is_active' => true,
            'email' => 'student@example.com',
        ]);

        $course = Course::create([
            'name_bn' => 'জাপানিজ ভাষা',
            'name_en' => 'Japanese',
            'level' => 'Level 2',
            'seats_total' => 20,
            'seats_available' => 20,
            'fee' => 0,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $this->actingAs($student)->post(route('applications.store'), [
            'course_id' => $course->id,
            'full_name' => 'টেস্ট শিক্ষার্থী',
            'nid' => '1234567890',
            'mobile' => '01712345678',
            'email' => 'student@example.com',
            'district' => 'Dhaka',
            'thana' => 'Dhanmondi',
            'bank_name' => 'DBBL',
            'bank_account' => '123456',
            'bank_branch' => 'Dhanmondi',
            'consent' => '1',
        ])->assertRedirect();

        Mail::assertSent(SiteMessageMail::class, function (SiteMessageMail $mail) {
            return $mail->hasTo('student@example.com')
                && str_contains($mail->subjectLine, 'আবেদন');
        });

        Mail::assertSent(SiteMessageMail::class, function (SiteMessageMail $mail) {
            return $mail->hasTo('help@suchana.bd')
                && str_contains($mail->subjectLine, 'নতুন আবেদন');
        });
    }

    public function test_status_change_emails_applicant(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'username' => 'mailadmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'username' => 'mailstu2',
            'role' => 'student',
            'is_active' => true,
        ]);

        $course = Course::create([
            'name_bn' => 'IT Support',
            'name_en' => 'IT Support',
            'level' => 'Level 2',
            'seats_total' => 10,
            'seats_available' => 10,
            'fee' => 0,
            'is_active' => true,
            'sort_order' => 1,
        ]);

        $application = Application::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'application_no' => 'APP-MAIL-1',
            'full_name' => 'Mail Student',
            'nid' => '111',
            'mobile' => '01799998888',
            'email' => 'applicant@example.com',
            'district' => 'Dhaka',
            'thana' => 'Mirpur',
            'bank_name' => 'BRAC',
            'bank_account' => '999',
            'bank_branch' => 'Mirpur',
            'status' => 'pending',
        ]);

        $this->actingAs($admin)
            ->post(route('admin.applications.status', $application), [
                'status' => 'approved',
            ])
            ->assertRedirect();

        Mail::assertSent(SiteMessageMail::class, function (SiteMessageMail $mail) {
            return $mail->hasTo('applicant@example.com')
                && str_contains($mail->subjectLine, 'অনুমোদিত');
        });
    }

    public function test_registration_sends_welcome_email(): void
    {
        Mail::fake();

        $this->post(route('register'), [
            'name' => 'New Student',
            'username' => 'newmailuser',
            'mobile' => '01755556666',
            'email' => 'newmail@example.com',
            'password' => 'secret12',
            'password_confirmation' => 'secret12',
        ])->assertRedirect(route('student.dashboard'));

        Mail::assertSent(SiteMessageMail::class, function (SiteMessageMail $mail) {
            return $mail->hasTo('newmail@example.com')
                && str_contains($mail->subjectLine, 'স্বাগতম');
        });
    }

    public function test_notice_creation_emails_all_active_users(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'username' => 'noticeadmin',
            'role' => 'admin',
            'is_active' => true,
            'email' => 'admin@example.com',
        ]);

        User::factory()->create([
            'username' => 'stu1',
            'role' => 'student',
            'is_active' => true,
            'email' => 'stu1@example.com',
        ]);

        User::factory()->create([
            'username' => 'stu2',
            'role' => 'student',
            'is_active' => true,
            'email' => 'stu2@example.com',
        ]);

        User::factory()->create([
            'username' => 'inactive',
            'role' => 'student',
            'is_active' => false,
            'email' => 'inactive@example.com',
        ]);

        $this->actingAs($admin)->post(route('admin.notices.store'), [
            'title_bn' => 'ভর্তি শুরু',
            'title_en' => 'Admission Open',
            'body_bn' => 'আগামী সপ্তাহে ভর্তি শুরু হবে।',
            'body_en' => 'Admission starts next week.',
            'type' => 'admission',
            'is_active' => '1',
            'notify_users' => '1',
        ])->assertRedirect(route('admin.notices.index'));

        Mail::assertSent(SiteMessageMail::class, 3);
        Mail::assertSent(SiteMessageMail::class, fn (SiteMessageMail $mail) => $mail->hasTo('stu1@example.com'));
        Mail::assertSent(SiteMessageMail::class, fn (SiteMessageMail $mail) => $mail->hasTo('stu2@example.com'));
        Mail::assertSent(SiteMessageMail::class, fn (SiteMessageMail $mail) => $mail->hasTo('admin@example.com'));
        Mail::assertNotSent(SiteMessageMail::class, fn (SiteMessageMail $mail) => $mail->hasTo('inactive@example.com'));
    }
}
