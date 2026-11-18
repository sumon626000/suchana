<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function index(Request $request): View
    {
        $q = $request->string('q')->toString();

        $students = User::where('role', 'student')
            ->when($q !== '', fn ($query) => $query->where(function ($qq) use ($q) {
                $qq->where('name', 'like', "%{$q}%")
                    ->orWhere('mobile', 'like', "%{$q}%")
                    ->orWhere('email', 'like', "%{$q}%")
                    ->orWhere('username', 'like', "%{$q}%");
            }))
            ->withCount('applications')
            ->latest()
            ->get();

        return view('admin.students.index', compact('students', 'q'));
    }

    public function show(User $student): View
    {
        abort_unless($student->role === 'student', 404);

        $student->load(['applications.course', 'certificates.course', 'attendances.course']);

        return view('admin.students.show', compact('student'));
    }

    public function toggle(User $student): RedirectResponse
    {
        abort_unless($student->role === 'student', 404);

        $student->is_active = ! $student->is_active;
        $student->save();

        return back()->with('success', 'শিক্ষার্থীর স্ট্যাটাস আপডেট হয়েছে।');
    }

    public function resetPassword(Request $request, User $student): RedirectResponse
    {
        abort_unless($student->role === 'student', 404);

        $data = $request->validate([
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $student->password = $data['password'];
        $student->save();

        return back()->with('success', 'শিক্ষার্থীর পাসওয়ার্ড রিসেট হয়েছে।');
    }
}
