<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        return view('admin.profile.password', [
            'admin' => request()->user(),
        ]);
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $admin = $request->user();

        $data = $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ], [
            'current_password.required' => 'বর্তমান পাসওয়ার্ড দিন।',
            'password.required' => 'নতুন পাসওয়ার্ড দিন।',
            'password.min' => 'নতুন পাসওয়ার্ড কমপক্ষে ৬ অক্ষরের হতে হবে।',
            'password.confirmed' => 'নতুন পাসওয়ার্ড মিলছে না।',
        ]);

        if (! Hash::check($data['current_password'], $admin->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'বর্তমান পাসওয়ার্ড ভুল।',
            ]);
        }

        $admin->password = $data['password'];
        $admin->save();

        return back()->with('success', 'অ্যাডমিন পাসওয়ার্ড পরিবর্তন হয়েছে।');
    }
}
