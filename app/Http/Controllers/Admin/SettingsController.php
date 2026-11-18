<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settings = Settings::all();

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:80'],
            'site_name_bn' => ['required', 'string', 'max:80'],
            'tagline_bn' => ['nullable', 'string', 'max:200'],
            'tagline_en' => ['nullable', 'string', 'max:200'],
            'phone' => ['nullable', 'string', 'max:40'],
            'email' => ['nullable', 'email', 'max:120'],
            'address_bn' => ['nullable', 'string', 'max:200'],
            'address_en' => ['nullable', 'string', 'max:200'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'facebook_url' => ['nullable', 'string', 'max:300'],
            'youtube_url' => ['nullable', 'string', 'max:300'],
            'instagram_url' => ['nullable', 'string', 'max:300'],
            'live_chat_script' => ['nullable', 'string'],
            'hero_badge_bn' => ['nullable', 'string', 'max:200'],
            'hero_badge_en' => ['nullable', 'string', 'max:200'],
            'about_bn' => ['nullable', 'string'],
            'about_en' => ['nullable', 'string'],
            'theme_color' => ['required', 'in:sky,charcoal,green,purple,red,teal,orange'],
        ]);

        $request->validate([
            'logo_suchana_file' => ['nullable', 'image', 'max:2048'],
            'logo_sfdb_file' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('logo_suchana_file')) {
            $data['logo_suchana'] = $request->file('logo_suchana_file')->store('branding', 'public');
        }

        if ($request->hasFile('logo_sfdb_file')) {
            $data['logo_sfdb'] = $request->file('logo_sfdb_file')->store('branding', 'public');
        }

        $data['live_chat_enabled'] = $request->boolean('live_chat_enabled') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        Settings::flush();

        return back()->with('success', 'সেটিংস সংরক্ষণ হয়েছে।');
    }
}
