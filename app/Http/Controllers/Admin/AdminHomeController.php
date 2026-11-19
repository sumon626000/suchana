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
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Throwable;

class AdminHomeController extends Controller
{
    public function index(): View
    {
        $stats = [
            'courses' => $this->safeCount(fn () => Course::count()),
            'students' => $this->safeCount(fn () => User::where('role', 'student')->count()),
            'applications' => $this->safeCount(fn () => Application::count()),
            'pending' => $this->safeCount(fn () => Application::where('status', 'pending')->count()),
            'branches' => $this->safeCount(fn () => Branch::count()),
            'notices' => $this->safeCount(fn () => Notice::count()),
            'staff' => $this->safeCount(fn () => Staff::count()),
            'certificates' => $this->safeCount(fn () => Certificate::count()),
            'today_attendance' => $this->safeCount(fn () => Attendance::whereDate('date', today())->count()),
        ];

        try {
            $recent = Application::query()
                ->with(['user', 'course'])
                ->latest()
                ->take(8)
                ->get();
        } catch (Throwable $e) {
            Log::warning('admin.dashboard.recent_failed', [
                'message' => $e->getMessage(),
            ]);

            $recent = collect();
        }

        return view('admin.dashboard', compact('stats', 'recent'));
    }

    private function safeCount(callable $callback): int
    {
        try {
            return (int) $callback();
        } catch (Throwable $e) {
            Log::warning('admin.dashboard.stat_failed', [
                'message' => $e->getMessage(),
            ]);

            return 0;
        }
    }
}
