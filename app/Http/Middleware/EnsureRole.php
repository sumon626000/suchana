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

            // Guests never reach here; wrong-role users go to a safe public page
            // instead of a dashboard that may itself error.
            $message = $user->role === 'student'
                ? 'এই পেজটি শুধু অ্যাডমিন/প্রশিক্ষকদের জন্য।'
                : 'আবেদন ফর্মটি শুধু শিক্ষার্থী অ্যাকাউন্টের জন্য। শিক্ষার্থী দিয়ে লগইন করুন।';

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('error', $message);
            }

            if ($user->role === 'trainer') {
                return redirect()->route('trainer.dashboard')->with('error', $message);
            }

            return redirect()->route('home')->with('error', $message);
        }

        return $next($request);
    }
}
