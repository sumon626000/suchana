<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ApplicationController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();
        $q = $request->string('q')->toString();

        $applications = Application::with(['user', 'course', 'batch'])
            ->when($status !== '', fn ($query) => $query->where('status', $status))
            ->when($q !== '', fn ($query) => $query->where(function ($qq) use ($q) {
                $qq->where('application_no', 'like', "%{$q}%")
                    ->orWhere('full_name', 'like', "%{$q}%")
                    ->orWhere('mobile', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%");
            }))
            ->latest()
            ->get();

        return view('admin.applications.index', compact('applications', 'status', 'q'));
    }

    public function show(Application $application): View
    {
        $application->load(['user', 'course', 'batch', 'reviewer']);

        return view('admin.applications.show', compact('application'));
    }

    public function export(Request $request): StreamedResponse
    {
        $status = $request->string('status')->toString();

        $applications = Application::with('course')
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->latest()
            ->get();

        $filename = 'applications-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($applications) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Application No', 'Name', 'Mobile', 'Email', 'District', 'Thana', 'Course', 'Status', 'Applied At']);

            foreach ($applications as $a) {
                fputcsv($out, [
                    $a->application_no,
                    $a->full_name,
                    $a->mobile,
                    $a->email,
                    $a->district,
                    $a->thana,
                    $a->course?->name_bn,
                    $a->status,
                    $a->created_at?->format('Y-m-d H:i'),
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function updateStatus(Request $request, Application $application): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:pending,verified,approved,cancelled,waitlist'],
            'rejection_reason' => ['nullable', 'string', 'max:500'],
        ]);

        $old = $application->status;

        $application->status = $data['status'];
        $application->rejection_reason = $data['status'] === 'cancelled' ? ($data['rejection_reason'] ?? null) : null;
        $application->reviewed_by = $request->user()->id;
        $application->reviewed_at = now();
        $application->save();

        $course = $application->course;

        if ($old !== 'approved' && $data['status'] === 'approved' && $course->seats_available > 0) {
            $course->decrement('seats_available');
        } elseif ($old === 'approved' && $data['status'] !== 'approved') {
            $course->increment('seats_available');
        }

        $this->logNotification($application, 'status_'.$data['status']);

        return back()->with('success', 'আবেদনের স্ট্যাটাস আপডেট হয়েছে।');
    }

    private function logNotification(Application $application, string $templateKey): void
    {
        $template = NotificationTemplate::where('key', $templateKey)->where('is_active', true)->first();

        if (! $template) {
            return;
        }

        $body = str_replace(
            ['{name}', '{app_no}', '{course}', '{status}', '{cert_no}'],
            [$application->full_name, $application->application_no, $application->course?->name_bn ?? '', $application->status, ''],
            $template->body_bn
        );

        NotificationLog::create([
            'template_key' => $templateKey,
            'channel' => $template->channel,
            'recipient' => $template->channel === 'email' ? ($application->email ?: $application->mobile) : $application->mobile,
            'message' => $body,
            'status' => 'queued',
        ]);
    }
}
