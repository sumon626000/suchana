<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\ShowcaseCertificateController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\Admin\SupportMessageController;
use App\Http\Controllers\Admin\ThanaController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SupportController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

// Hostinger-safe fallback when `php artisan storage:link` is unavailable.
Route::get('/storage/{path}', function (string $path): BinaryFileResponse {
    $full = storage_path('app/public/'.str_replace('..', '', $path));

    abort_unless(is_file($full), 404);

    return response()->file($full);
})->where('path', '.*')->name('storage.fallback');

Route::controller(PublicController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/courses', 'courses')->name('courses.index');
    Route::get('/courses/{course}', 'course')->name('courses.show');
    Route::get('/branches', 'branches')->name('branches.index');
    Route::get('/notices', 'notices')->name('notices.index');
    Route::get('/about', 'about')->name('about');
    Route::get('/contact', 'contact')->name('contact');
    Route::get('/privacy', 'privacy')->name('privacy');
    Route::get('/terms', 'terms')->name('terms');
    Route::get('/faq', 'faq')->name('faq');
});

Route::get('/track', [ApplicationController::class, 'trackForm'])->name('track');
Route::post('/track', [ApplicationController::class, 'track'])->name('track.post');

Route::post('/support', [SupportController::class, 'store'])->name('support.store');

Route::get('/certificate/{no}', [CertificateController::class, 'show'])->name('certificate.show');
Route::get('/certificate/{no}/pdf', [CertificateController::class, 'pdf'])->name('certificate.pdf');
Route::get('/verify', [CertificateController::class, 'verifyForm'])->name('verify');
Route::post('/verify', [CertificateController::class, 'verify'])->name('verify.post');
Route::get('/verify/{code}', [CertificateController::class, 'verifyCode'])->name('verify.code');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot-password', [PasswordResetController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'store'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'edit'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'update'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ---- Separate admin authentication (/admin/login) ----
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login']);
    Route::post('/logout', [AdminAuthController::class, 'logout'])->middleware('auth')->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/apply', [ApplicationController::class, 'create'])
        ->middleware('role:student')->name('applications.create');
    Route::post('/apply', [ApplicationController::class, 'store'])
        ->middleware('role:student')->name('applications.store');
    Route::get('/applications/{application}', [ApplicationController::class, 'show'])
        ->name('applications.show');

    Route::get('/student', [StudentController::class, 'dashboard'])
        ->middleware('role:student')->name('student.dashboard');
    Route::get('/student/profile', [StudentController::class, 'profileForm'])
        ->middleware('role:student')->name('student.profile');
    Route::post('/student/profile', [StudentController::class, 'profileUpdate'])
        ->middleware('role:student')->name('student.profile.update');

    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->middleware('role:admin,trainer')->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])
        ->middleware('role:admin,trainer')->name('attendance.store');

    Route::get('/attendance/qr', [AttendanceController::class, 'qrImage'])
        ->middleware('role:admin,trainer')->name('attendance.qr');
    Route::get('/attendance/scan', [AttendanceController::class, 'scanForm'])
        ->middleware('role:student')->name('attendance.scan');
    Route::post('/attendance/scan', [AttendanceController::class, 'scanStore'])
        ->middleware('role:student')->name('attendance.scan.store');

    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        // Use /admin/dashboard — bare /admin can 500 on Hostinger/CDN edge setups.
        Route::get('/dashboard', [AdminHomeController::class, 'index'])->name('dashboard');
        Route::get('/', fn () => redirect()->route('admin.dashboard'));

        Route::resource('courses', CourseController::class)->except('show');
        Route::resource('batches', BatchController::class)->except('show');
        Route::resource('staff', StaffController::class)->except('show');
        Route::resource('branches', BranchController::class)->except('show');
        Route::resource('districts', DistrictController::class)->except('show');
        Route::resource('thanas', ThanaController::class)->except('show');
        Route::resource('gallery', GalleryController::class)->except('show');
        Route::resource('showcase-certificates', ShowcaseCertificateController::class)->except('show');
        Route::resource('notices', NoticeController::class)->except('show');

        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/export', [AdminApplicationController::class, 'export'])->name('applications.export');
        Route::get('/applications/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
        Route::post('/applications/{application}/status', [AdminApplicationController::class, 'updateStatus'])->name('applications.status');

        Route::get('/students', [AdminStudentController::class, 'index'])->name('students.index');
        Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('students.show');
        Route::post('/students/{student}/toggle', [AdminStudentController::class, 'toggle'])->name('students.toggle');
        Route::post('/students/{student}/password', [AdminStudentController::class, 'resetPassword'])->name('students.password');
        Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('students.destroy');

        Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
        Route::get('/attendance/export', [AttendanceController::class, 'export'])->name('attendance.export');

        Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
        Route::post('/certificates', [CertificateController::class, 'store'])->name('certificates.store');
        Route::post('/certificates/auto', [CertificateController::class, 'auto'])->name('certificates.auto');
        Route::post('/certificates/{certificate}/pdf', [CertificateController::class, 'uploadPdf'])->name('certificates.upload-pdf');
        Route::delete('/certificates/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.destroy');

        Route::get('/profile/password', [AdminProfileController::class, 'edit'])->name('profile.password.edit');
        Route::post('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.password');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');

        Route::get('/backups', [BackupController::class, 'index'])->name('backups.index');
        Route::post('/backups', [BackupController::class, 'create'])->name('backups.create');
        Route::get('/backups/{file}/download', [BackupController::class, 'download'])->name('backups.download');
        Route::delete('/backups/{file}', [BackupController::class, 'destroy'])->name('backups.destroy');

        Route::get('/support', [SupportMessageController::class, 'index'])->name('support.index');
        Route::delete('/support/{message}', [SupportMessageController::class, 'destroy'])->name('support.destroy');

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/logs', [NotificationController::class, 'logs'])->name('notifications.logs');
        Route::get('/notifications/{template}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
        Route::put('/notifications/{template}', [NotificationController::class, 'update'])->name('notifications.update');
    });

    Route::get('/trainer', fn () => view('trainer.dashboard'))
        ->middleware('role:trainer')->name('trainer.dashboard');
});
