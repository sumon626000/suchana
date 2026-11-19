<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        if (Auth::check() && ! Auth::user()->isAdmin()) {
            Auth::logout();
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('username', $data['login'])
            ->orWhere('email', $data['login'])
            ->orWhere('mobile', $data['login'])
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()->withInput()->withErrors(['login' => 'ভুল তথ্য বা পাসওয়ার্ড।']);
        }

        if ($user->role !== 'admin') {
            return back()->withInput()->withErrors([
                'login' => 'এই অ্যাকাউন্টটি অ্যাডমিন নয়। শুধুমাত্র অ্যাডমিন অ্যাকাউন্ট দিয়ে লগইন করুন।',
            ]);
        }

        if (! $user->is_active) {
            return back()->withInput()->withErrors(['login' => 'আপনার অ্যাকাউন্ট নিষ্ক্রিয়।']);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Always land on /admin/dashboard — bare /admin can 500 on Hostinger.
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request): RedirectResponse
    {
        $role = Auth::user()?->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $role === 'admin'
            ? redirect()->route('admin.login')
            : redirect()->route('home');
    }
}
