<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showRegister(): View
    {
        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'username' => ['required', 'string', 'min:3', 'max:30', 'alpha_dash', 'unique:users,username'],
            'mobile' => ['required', 'regex:/^01[3-9]\d{8}$/', 'unique:users,mobile'],
            'email' => ['required', 'email', 'max:120', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'mobile.regex' => 'সঠিক মোবাইল নম্বর দিন (যেমন: 017XXXXXXXX)।',
            'username.unique' => 'এই ইউজারনেম আগে থেকেই নেওয়া হয়েছে।',
            'email.unique' => 'এই ইমেইল আগে থেকেই ব্যবহৃত।',
            'mobile.unique' => 'এই মোবাইল নম্বর আগে থেকেই ব্যবহৃত।',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'mobile' => $data['mobile'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'student',
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('student.dashboard')
            ->with('success', 'রেজিস্ট্রেশন সফল হয়েছে। স্বাগতম!');
    }

    public function showLogin(): View
    {
        return view('auth.login');
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

        if (! $user->is_active) {
            return back()->withInput()->withErrors(['login' => 'আপনার অ্যাকাউন্ট নিষ্ক্রিয়।']);
        }

        if ($user->role === 'admin') {
            return back()->withInput()->withErrors([
                'login' => 'অ্যাডমিন লগইনের জন্য আলাদা পেজ ব্যবহার করুন: /admin/login',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPathFor($user));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function redirectPathFor(User $user): string
    {
        return match ($user->role) {
            'admin' => route('admin.dashboard'),
            'trainer' => route('trainer.dashboard'),
            default => route('student.dashboard'),
        };
    }
}
