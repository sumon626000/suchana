<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Attendance;
use App\Models\Branch;
use App\Models\Certificate;
use App\Models\Course;
use App\Models\Notice;
use App\Models\Staff;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'courses' => Course::count(),
            'students' => User::where('role', 'student')->count(),
            'applications' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'branches' => Branch::count(),
            'notices' => Notice::count(),
            'staff' => Staff::count(),
            'certificates' => Certificate::count(),
            'today_attendance' => Attendance::whereDate('date', today())->count(),
        ];

        $recent = Application::with(['user', 'course'])->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'recent'));
    }
}
