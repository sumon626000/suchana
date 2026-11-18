<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (! $user->is_active) {
            auth()->logout();

            return redirect()->route('login')->withErrors(['login' => 'Your account is inactive.']);
        }

        if (! in_array($user->role, $roles, true)) {
            if ($request->expectsJson()) {
                abort(403, 'Unauthorized access.');
            }

            $fallback = match ($user->role) {
                'admin' => 'admin.dashboard',
                'trainer' => 'trainer.dashboard',
                default => 'student.dashboard',
            };

            $message = $user->role === 'student'
                ? 'এই পেজটি শুধু অ্যাডমিন/প্রশিক্ষকদের জন্য।'
                : 'আবেদন ফর্মটি শুধু শিক্ষার্থীদের জন্য। শিক্ষার্থী অ্যাকাউন্ট দিয়ে লগইন করুন।';

            return redirect()->route($fallback)->with('error', $message);
        }

        return $next($request);
    }
}
