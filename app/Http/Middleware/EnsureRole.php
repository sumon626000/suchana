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
            return $request->is('admin', 'admin/*')
                ? redirect()->route('admin.login')
                : redirect()->route('login');
        }

        if (! $user->is_active) {
            auth()->logout();

            $loginRoute = $request->is('admin', 'admin/*') ? 'admin.login' : 'login';

            return redirect()->route($loginRoute)->withErrors(['login' => 'Your account is inactive.']);
        }

        if (! in_array($user->role, $roles, true)) {
            if ($request->expectsJson()) {
                abort(403, 'Unauthorized access.');
            }

            // Keep admin inside /admin and student/user flows on the public site.
            // Never dump admins into the admin panel when they click a user-panel link.
            if ($user->role === 'admin') {
                return redirect()->route('home')->with(
                    'error',
                    'এটি ইউজার/শিক্ষার্থী পেজ। অ্যাডমিন প্যানেল শুধু /admin থেকে ব্যবহার করুন।'
                );
            }

            if ($user->role === 'trainer') {
                return redirect()->route('trainer.dashboard')->with(
                    'error',
                    'এই পেজটি আপনার রোলের জন্য নয়।'
                );
            }

            return redirect()->route('home')->with(
                'error',
                $user->role === 'student'
                    ? 'এই পেজটি শুধু অ্যাডমিন/প্রশিক্ষকদের জন্য।'
                    : 'আবেদন ফর্মটি শুধু শিক্ষার্থী অ্যাকাউন্টের জন্য। শিক্ষার্থী দিয়ে লগইন করুন।'
            );
        }

        return $next($request);
    }
}
