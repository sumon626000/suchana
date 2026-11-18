<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Course;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $data['login'])
            ->orWhere('email', $data['login'])
            ->orWhere('mobile', $data['login'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password) || ! $user->is_active) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = $user->createToken('api')->plainTextToken;

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'role' => $user->role,
            ],
        ]);
    }

    public function courses(): JsonResponse
    {
        $courses = Course::where('is_active', true)
            ->orderBy('sort_order')
            ->get(['id', 'name_bn', 'name_en', 'level', 'duration_bn', 'duration_en', 'seats_total', 'seats_available', 'fee', 'stipend_male', 'stipend_female', 'application_deadline']);

        return response()->json(['data' => $courses]);
    }

    public function notices(): JsonResponse
    {
        $notices = Notice::where('is_active', true)
            ->orderByDesc('published_at')
            ->get(['id', 'title_bn', 'title_en', 'body_bn', 'body_en', 'type', 'published_at']);

        return response()->json(['data' => $notices]);
    }

    public function adminStats(): JsonResponse
    {
        return response()->json([
            'courses' => Course::count(),
            'students' => User::where('role', 'student')->count(),
            'applications' => Application::count(),
            'pending' => Application::where('status', 'pending')->count(),
            'branches' => \App\Models\Branch::count(),
            'certificates' => \App\Models\Certificate::count(),
        ]);
    }

    public function applications(Request $request): JsonResponse
    {
        $applications = Application::with(['course:id,name_bn', 'user:id,name'])
            ->when($request->string('status')->toString(), fn ($q, $s) => $q->where('status', $s))
            ->latest()
            ->take(100)
            ->get(['id', 'application_no', 'full_name', 'mobile', 'status', 'course_id', 'user_id', 'created_at']);

        return response()->json(['data' => $applications]);
    }
}
