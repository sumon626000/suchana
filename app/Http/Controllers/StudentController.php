<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();

        $applications = $user->applications()->with(['course', 'batch'])->latest()->get();
        $certificates = $user->certificates()->with('course')->latest('issued_at')->get();
        $attendances = $user->attendances()->with(['course', 'batch'])->orderByDesc('date')->get();

        $attendanceSummary = [
            'present' => $attendances->where('status', 'present')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
            'total' => $attendances->count(),
        ];

        $attendanceRate = $attendanceSummary['total']
            ? (int) round($attendanceSummary['present'] / $attendanceSummary['total'] * 100)
            : 0;

        $courseAttendance = $attendances->groupBy('course_id')->map(function ($rows) {
            $total = $rows->count();
            $present = $rows->where('status', 'present')->count();

            return [
                'course' => $rows->first()->course,
                'present' => $present,
                'total' => $total,
                'rate' => $total ? (int) round($present / $total * 100) : 0,
            ];
        })->filter(fn ($row) => $row['course'] !== null)->values();

        $applicationsPending = $applications->where('status', 'pending')->count();
        $applicationsApproved = $applications->where('status', 'approved')->count();

        return view('student.dashboard', compact(
            'user',
            'applications',
            'certificates',
            'attendances',
            'attendanceSummary',
            'attendanceRate',
            'courseAttendance',
            'applicationsPending',
            'applicationsApproved'
        ));
    }

    public function profileForm(Request $request): View
    {
        return view('student.profile', ['user' => $request->user()]);
    }

    public function profileUpdate(Request $request): RedirectResponse
    {
        $user = $request->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'mobile' => ['nullable', 'string', 'max:20', Rule::unique('users', 'mobile')->ignore($user->id)],
            'email' => ['required', 'email', 'max:150', Rule::unique('users', 'email')->ignore($user->id)],
            'photo_file' => ['nullable', 'image', 'max:2048'],
            'current_password' => ['nullable', 'required_with:password', 'current_password'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $user->name = $data['name'];
        $user->mobile = $data['mobile'] ?? null;
        $user->email = $data['email'];

        if ($request->hasFile('photo_file')) {
            $user->photo = $request->file('photo_file')->store('students', 'public');
        }

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        $user->save();

        return back()->with('success', 'প্রোফাইল সফলভাবে আপডেট হয়েছে।');
    }
}
