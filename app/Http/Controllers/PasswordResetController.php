<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'login' => ['required', 'string', 'max:120'],
        ], [
            'login.required' => 'ইমেইল, ইউজারনেম বা মোবাইল দিন।',
        ]);

        $user = $this->findUserByLogin($data['login']);

        if ($user?->email) {
            Password::sendResetLink(['email' => $user->email]);
        }

        // Always show the same message to avoid account enumeration.
        return back()->with(
            'success',
            'পাসওয়ার্ড রিসেট লিংক পাঠানো হয়েছে (অ্যাকাউন্ট থাকলে)। ইমেইল ইনবক্স ও স্প্যাম ফোল্ডার চেক করুন।'
        );
    }

    public function edit(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email', 'max:120'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'পাসওয়ার্ড নিশ্চিতকরণ মিলছে না।',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => $password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PasswordReset) {
            $user = User::query()->where('email', $data['email'])->first();
            $loginRoute = $user?->isAdmin() ? route('admin.login') : route('login');

            return redirect($loginRoute)->with('success', 'পাসওয়ার্ড সফলভাবে পরিবর্তন হয়েছে। এখন লগইন করুন।');
        }

        return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => 'রিসেট লিংক অবৈধ বা মেয়াদোত্তীর্ণ। আবার অনুরোধ করুন।']);
    }

    private function findUserByLogin(string $login): ?User
    {
        return User::query()
            ->where('email', $login)
            ->orWhere('username', $login)
            ->orWhere('mobile', $login)
            ->first();
    }
}
