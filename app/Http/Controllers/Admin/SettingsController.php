<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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
            'brand_title_bn' => ['nullable', 'string', 'max:120'],
            'brand_title_en' => ['nullable', 'string', 'max:120'],
            'hero_title_line1_bn' => ['nullable', 'string', 'max:120'],
            'hero_title_line1_en' => ['nullable', 'string', 'max:120'],
            'hero_title_line2_bn' => ['nullable', 'string', 'max:120'],
            'hero_title_line2_en' => ['nullable', 'string', 'max:120'],
            'hero_subtitle_bn' => ['nullable', 'string', 'max:500'],
            'hero_subtitle_en' => ['nullable', 'string', 'max:500'],
            'home_running_kicker_bn' => ['nullable', 'string', 'max:80'],
            'home_running_kicker_en' => ['nullable', 'string', 'max:80'],
            'home_running_title_bn' => ['nullable', 'string', 'max:120'],
            'home_running_title_en' => ['nullable', 'string', 'max:120'],
            'home_running_lead_bn' => ['nullable', 'string', 'max:300'],
            'home_running_lead_en' => ['nullable', 'string', 'max:300'],
            'home_courses_kicker_bn' => ['nullable', 'string', 'max:80'],
            'home_courses_kicker_en' => ['nullable', 'string', 'max:80'],
            'home_courses_title_bn' => ['nullable', 'string', 'max:120'],
            'home_courses_title_en' => ['nullable', 'string', 'max:120'],
            'home_courses_lead_bn' => ['nullable', 'string', 'max:300'],
            'home_courses_lead_en' => ['nullable', 'string', 'max:300'],
            'theme_color' => ['required', 'in:sky,charcoal,green,purple,red,teal,orange'],
            'hero_image' => ['nullable', 'string', 'max:500'],
        ]);

        $request->validate([
            'logo_suchana_file' => ['nullable', 'image', 'max:2048'],
            'logo_sfdb_file' => ['nullable', 'image', 'max:2048'],
            'hero_image_file' => ['nullable', 'image', 'max:5120'],
            'remove_hero_image' => ['nullable', 'boolean'],
        ]);

        unset($data['hero_image']);

        if ($request->hasFile('logo_suchana_file')) {
            $data['logo_suchana'] = $request->file('logo_suchana_file')->store('branding', 'public');
        }

        if ($request->hasFile('logo_sfdb_file')) {
            $data['logo_sfdb'] = $request->file('logo_sfdb_file')->store('branding', 'public');
        }

        if ($request->boolean('remove_hero_image')) {
            $this->deletePublicUpload(Settings::get('hero_image'));
            $data['hero_image'] = '';
        }

        if ($request->hasFile('hero_image_file')) {
            $this->deletePublicUpload(Settings::get('hero_image'));
            $data['hero_image'] = $this->storePublicImage($request->file('hero_image_file'), 'home');
        } elseif ($request->filled('hero_image') && ! $request->boolean('remove_hero_image')) {
            $data['hero_image'] = $request->string('hero_image')->toString();
        }

        $data['live_chat_enabled'] = $request->boolean('live_chat_enabled') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        Settings::flush();

        return back()->with('success', 'সেটিংস সংরক্ষণ হয়েছে।');
    }

    private function storePublicImage(UploadedFile $file, string $folder): string
    {
        $directory = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($directory);

        $filename = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $file->move($directory, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    private function deletePublicUpload(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        if (str_starts_with($path, 'uploads/') && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
