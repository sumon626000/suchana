<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Batch;
use App\Models\Course;
use App\Models\User;
use Endroid\QrCode\Builder\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $courses = Course::where('is_active', true)
            ->when($user->role === 'trainer', fn ($q) => $q->whereHas('batches', fn ($b) => $b->where('trainer_id', $user->id)))
            ->orderBy('sort_order')
            ->get();

        $courseId = $request->integer('course') ?: $courses->first()?->id;

        $batches = Batch::where('course_id', $courseId)
            ->when($user->role === 'trainer', fn ($q) => $q->where('trainer_id', $user->id))
            ->where('is_active', true)
            ->get();

        $batchId = $request->integer('batch') ?: $batches->first()?->id;
        $date = $request->date('date')?->toDateString() ?? today()->toDateString();

        $students = collect();

        if ($courseId) {
            $students = User::where('role', 'student')
                ->whereHas('applications', function ($q) use ($courseId, $batchId) {
                    $q->where('course_id', $courseId)
                        ->whereIn('status', ['approved', 'verified'])
                        ->when($batchId, fn ($qq) => $qq->where('batch_id', $batchId));
                })
                ->orderBy('name')
                ->get();
        }

        $existing = Attendance::where('course_id', $courseId)
            ->where('date', $date)
            ->get()
            ->keyBy('student_id');

        return view('attendance.index', compact('courses', 'courseId', 'batches', 'batchId', 'date', 'students', 'existing'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'batch_id' => ['nullable', 'exists:batches,id'],
            'date' => ['required', 'date'],
            'marks' => ['required', 'array'],
            'marks.*' => ['in:present,absent,late'],
        ]);

        $count = 0;

        foreach ($data['marks'] as $studentId => $status) {
            $attendance = Attendance::where('student_id', $studentId)
                ->where('course_id', $data['course_id'])
                ->whereDate('date', $data['date'])
                ->first();

            if ($attendance) {
                $attendance->update([
                    'batch_id' => $data['batch_id'],
                    'status' => $status,
                    'method' => 'manual',
                    'marked_by' => $request->user()->id,
                ]);
            } else {
                Attendance::create([
                    'student_id' => $studentId,
                    'course_id' => $data['course_id'],
                    'batch_id' => $data['batch_id'],
                    'date' => $data['date'],
                    'status' => $status,
                    'method' => 'manual',
                    'marked_by' => $request->user()->id,
                ]);
            }

            $count++;
        }

        return back()->with('success', "উপস্থিতি সংরক্ষণ হয়েছে ({$count} জন শিক্ষার্থী)।");
    }

    public function report(Request $request): View
    {
        $courseId = $request->integer('course') ?: null;
        $from = $request->date('from')?->toDateString() ?? now()->startOfMonth()->toDateString();
        $to = $request->date('to')?->toDateString() ?? now()->toDateString();

        $courses = Course::orderBy('sort_order')->get();

        $records = Attendance::with(['student', 'course'])
            ->whereDate('date', '>=', $from)
            ->whereDate('date', '<=', $to)
            ->when($courseId, fn ($q) => $q->where('course_id', $courseId))
            ->get();

        $summary = $records->groupBy('student_id')->map(function ($rows) {
            $student = $rows->first()->student;

            return [
                'name' => $student?->name ?? 'Unknown',
                'mobile' => $student?->mobile,
                'present' => $rows->where('status', 'present')->count(),
                'absent' => $rows->where('status', 'absent')->count(),
                'late' => $rows->where('status', 'late')->count(),
                'total' => $rows->count(),
            ];
        })->values();

        return view('attendance.report', compact('courses', 'courseId', 'from', 'to', 'summary'));
    }

    public function export(Request $request): StreamedResponse
    {
        $courseId = $request->integer('course') ?: null;
        $from = $request->date('from')?->toDateString() ?? now()->startOfMonth()->toDateString();
        $to = $request->date('to')?->toDateString() ?? now()->toDateString();

        $records = Attendance::with(['student', 'course'])
            ->whereDate('date', '>=', $from)
            ->whereDate('date', '<=', $to)
            ->when($courseId, fn ($q) => $q->where('course_id', $courseId))
            ->orderBy('date')
            ->get();

        $filename = 'attendance-'.$from.'-to-'.$to.'-'.now()->format('Ymd-His').'.csv';

        return response()->streamDownload(function () use ($records) {
            $out = fopen('php://output', 'w');
            fwrite($out, "\xEF\xBB\xBF");
            fputcsv($out, ['Date', 'Student', 'Mobile', 'Course', 'Status', 'Method']);

            foreach ($records as $r) {
                fputcsv($out, [
                    $r->date?->format('Y-m-d'),
                    $r->student?->name,
                    $r->student?->mobile,
                    $r->course?->name_bn,
                    $r->status,
                    $r->method,
                ]);
            }

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    // ---------------- QR self check-in ----------------

    public function qrImage(Request $request): Response
    {
        $courseId = (int) $request->integer('course');
        $batchId = $request->integer('batch') ?: null;
        $date = $request->date('date')?->toDateString() ?? today()->toDateString();

        if (! Course::whereKey($courseId)->exists()) {
            abort(404, 'Course not found');
        }

        $token = $this->makeAttendanceToken($courseId, $batchId, $date);
        $url = route('attendance.scan', ['token' => $token]);

        $result = (new Builder)->build(data: $url, size: 380, margin: 12);

        return response($result->getString(), 200, ['Content-Type' => 'image/png', 'Cache-Control' => 'no-store']);
    }

    public function scanForm(Request $request): View
    {
        $token = (string) $request->query('token', '');
        $session = $this->parseAttendanceToken($token);
        $course = $session ? Course::find($session['course_id']) : null;
        $batch = $session && $session['batch_id'] ? Batch::find($session['batch_id']) : null;
        $already = false;

        if ($session && $request->user()) {
            $already = Attendance::where('student_id', $request->user()->id)
                ->where('course_id', $session['course_id'])
                ->whereDate('date', $session['date'])
                ->exists();
        }

        return view('attendance.scan', compact('token', 'session', 'course', 'batch', 'already'));
    }

    public function scanStore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string', 'max:255'],
        ]);

        $session = $this->parseAttendanceToken($data['token']);

        if (! $session) {
            return back()->with('error', 'QR কোডটি অবৈধ বা মেয়াদোত্তীর্ণ।');
        }

        $student = $request->user();

        $existing = Attendance::where('student_id', $student->id)
            ->where('course_id', $session['course_id'])
            ->whereDate('date', $session['date'])
            ->first();

        if ($existing) {
            return redirect()->route('student.dashboard')
                ->with('success', 'আপনি ইতিমধ্যে এই ক্লাসে উপস্থিতি দিয়েছেন।');
        }

        Attendance::create([
            'student_id' => $student->id,
            'course_id' => $session['course_id'],
            'batch_id' => $session['batch_id'],
            'date' => $session['date'],
            'status' => 'present',
            'method' => 'qr',
            'marked_by' => null,
            'notes' => 'QR self check-in',
        ]);

        return redirect()->route('student.dashboard')
            ->with('success', 'উপস্থিতি সফলভাবে রেকর্ড হয়েছে। ধন্যবাদ!');
    }

    private function makeAttendanceToken(int $courseId, ?int $batchId, string $date): string
    {
        $payload = $courseId.'|'.($batchId ?? 0).'|'.$date;
        $sig = substr(hash_hmac('sha256', $payload, (string) config('app.key')), 0, 16);

        return rtrim(strtr(base64_encode($payload.'|'.$sig), '+/', '-_'), '=');
    }

    private function parseAttendanceToken(string $token): ?array
    {
        if ($token === '') {
            return null;
        }

        $raw = base64_decode(strtr($token, '-_', '+/'), true);

        if ($raw === false) {
            return null;
        }

        $parts = explode('|', $raw);

        if (count($parts) !== 4) {
            return null;
        }

        [$courseId, $batchId, $date, $sig] = $parts;

        $payload = $courseId.'|'.$batchId.'|'.$date;
        $expected = substr(hash_hmac('sha256', $payload, (string) config('app.key')), 0, 16);

        if (! hash_equals($expected, $sig)) {
            return null;
        }

        return [
            'course_id' => (int) $courseId,
            'batch_id' => ((int) $batchId) ?: null,
            'date' => $date,
        ];
    }
}
