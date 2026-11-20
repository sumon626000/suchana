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
use Illuminate\Validation\ValidationException;
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
            'whatsapp_number' => ['nullable', 'string', 'max:40'],
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
            'brand_sub_bn' => ['nullable', 'string', 'max:120'],
            'brand_sub_en' => ['nullable', 'string', 'max:120'],
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
        ]);

        $request->validate([
            'logo_suchana_file' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'logo_sfdb_file' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:4096'],
            'hero_image_file' => ['nullable', 'array', 'max:5'],
            'hero_image_file.*' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'hero_images_bulk' => ['nullable', 'array', 'max:5'],
            'hero_images_bulk.*' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
            'remove_hero_image' => ['nullable', 'array'],
            'remove_hero_image.*' => ['nullable', 'boolean'],
        ], [
            'logo_suchana_file.image' => 'সুচনা লোগো JPG, PNG, WebP বা GIF হতে হবে।',
            'logo_suchana_file.mimes' => 'সুচনা লোগো JPG, PNG, WebP বা GIF হতে হবে।',
            'logo_suchana_file.max' => 'সুচনা লোগো সর্বোচ্চ ৪MB হতে পারবে।',
            'logo_sfdb_file.image' => 'SFDB লোগো JPG, PNG, WebP বা GIF হতে হবে।',
            'logo_sfdb_file.mimes' => 'SFDB লোগো JPG, PNG, WebP বা GIF হতে হবে।',
            'logo_sfdb_file.max' => 'SFDB লোগো সর্বোচ্চ ৪MB হতে পারবে।',
            'hero_image_file.*.image' => 'হিরো ছবি অবশ্যই JPG, PNG, WebP বা GIF হতে হবে।',
            'hero_image_file.*.mimes' => 'হিরো ছবি অবশ্যই JPG, PNG, WebP বা GIF হতে হবে।',
            'hero_image_file.*.max' => 'প্রতিটি হিরো ছবি সর্বোচ্চ ৫MB হতে পারবে।',
            'hero_images_bulk.*.image' => 'হিরো ছবি অবশ্যই JPG, PNG, WebP বা GIF হতে হবে।',
            'hero_images_bulk.*.mimes' => 'হিরো ছবি অবশ্যই JPG, PNG, WebP বা GIF হতে হবে।',
            'hero_images_bulk.*.max' => 'প্রতিটি হিরো ছবি সর্বোচ্চ ৫MB হতে পারবে।',
            'hero_images_bulk.max' => 'একসাথে সর্বোচ্চ ৫টি হিরো ছবি আপলোড করা যাবে।',
        ]);

        $data['whatsapp_number'] = Settings::whatsappDigits($data['whatsapp_number'] ?? null);
        $data['facebook_url'] = Settings::absoluteUrl($data['facebook_url'] ?? null);
        $data['youtube_url'] = Settings::absoluteUrl($data['youtube_url'] ?? null);
        $data['instagram_url'] = Settings::absoluteUrl($data['instagram_url'] ?? null);

        if ($request->hasFile('logo_suchana_file')) {
            $logo = $request->file('logo_suchana_file');
            if (! $logo instanceof UploadedFile || ! $logo->isValid()) {
                throw ValidationException::withMessages([
                    'logo_suchana_file' => 'সুচনা লোগো আপলোড ব্যর্থ হয়েছে।',
                ]);
            }
            $this->deleteStoredMedia(Settings::get('logo_suchana'));
            $data['logo_suchana'] = $this->storePublicImage($logo, 'branding');
        }

        if ($request->hasFile('logo_sfdb_file')) {
            $logo = $request->file('logo_sfdb_file');
            if (! $logo instanceof UploadedFile || ! $logo->isValid()) {
                throw ValidationException::withMessages([
                    'logo_sfdb_file' => 'SFDB লোগো আপলোড ব্যর্থ হয়েছে।',
                ]);
            }
            $this->deleteStoredMedia(Settings::get('logo_sfdb'));
            $data['logo_sfdb'] = $this->storePublicImage($logo, 'branding');
        }

        $this->applyHeroSlotUploads($request, $data);
        $this->applyHeroBulkUploads($request, $data);

        $heroImage1 = array_key_exists('hero_image_1', $data)
            ? $data['hero_image_1']
            : (string) Settings::get('hero_image_1', Settings::get('hero_image', ''));
        $data['hero_image'] = $heroImage1;

        $data['live_chat_enabled'] = $request->boolean('live_chat_enabled') ? '1' : '0';

        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value ?? '']);
        }

        Settings::flush();

        $activeHeroCount = collect(range(1, 5))
            ->filter(function (int $slot) {
                return filled(Settings::get('hero_image_'.$slot, $slot === 1 ? Settings::get('hero_image', '') : ''));
            })
            ->count();

        return back()->with('success', "সেটিংস সংরক্ষণ হয়েছে। হিরো স্লাইডার: {$activeHeroCount}/৫টি ছবি সক্রিয়।");
    }

    /**
     * @param  array<string, mixed>  $data
     */
    private function applyHeroSlotUploads(Request $request, array &$data): void
    {
        $uploads = $request->file('hero_image_file', []);
        if ($uploads instanceof UploadedFile) {
            $uploads = [1 => $uploads];
        }
        if (! is_array($uploads)) {
            $uploads = [];
        }

        for ($slot = 1; $slot <= 5; $slot++) {
            $key = 'hero_image_'.$slot;

            if ($request->boolean("remove_hero_image.$slot")) {
                $this->deleteStoredMedia(Settings::get($key));
                $data[$key] = '';

                continue;
            }

            $file = $uploads[$slot] ?? $uploads[(string) $slot] ?? null;
            if (! $file instanceof UploadedFile) {
                continue;
            }

            $data[$key] = $this->storeValidHeroImage($file, $slot, Settings::get($key));
        }
    }

    /**
     * Fill slots 1..N in order from a multi-select upload (overwrites those slots).
     *
     * @param  array<string, mixed>  $data
     */
    private function applyHeroBulkUploads(Request $request, array &$data): void
    {
        $bulk = $request->file('hero_images_bulk', []);
        if ($bulk instanceof UploadedFile) {
            $bulk = [$bulk];
        }
        if (! is_array($bulk) || $bulk === []) {
            return;
        }

        $files = array_values(array_filter(
            $bulk,
            fn ($file) => $file instanceof UploadedFile
        ));

        foreach ($files as $index => $file) {
            $slot = $index + 1;
            if ($slot > 5) {
                break;
            }

            $key = 'hero_image_'.$slot;
            $previous = array_key_exists($key, $data) ? $data[$key] : Settings::get($key);
            $data[$key] = $this->storeValidHeroImage($file, $slot, is_string($previous) ? $previous : null);
        }
    }

    private function storeValidHeroImage(UploadedFile $file, int $slot, ?string $previousPath): string
    {
        if (! $file->isValid()) {
            throw ValidationException::withMessages([
                "hero_image_file.$slot" => 'ছবি '.$slot.' আপলোড ব্যর্থ হয়েছে: '.$file->getErrorMessage(),
            ]);
        }

        $this->deleteStoredMedia($previousPath);

        return $this->storePublicImage($file, 'home');
    }

    private function storePublicImage(UploadedFile $file, string $folder): string
    {
        $directory = public_path('uploads/'.$folder);
        File::ensureDirectoryExists($directory);

        $extension = strtolower((string) ($file->getClientOriginalExtension() ?: $file->guessExtension() ?: 'jpg'));
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        if (! in_array($extension, $allowed, true)) {
            $extension = 'jpg';
        }

        $filename = Str::uuid()->toString().'.'.$extension;
        $file->move($directory, $filename);

        return 'uploads/'.$folder.'/'.$filename;
    }

    private function deleteStoredMedia(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return;
        }

        if (str_starts_with($path, 'uploads/') && File::exists(public_path($path))) {
            File::delete(public_path($path));

            return;
        }

        $legacyStorage = storage_path('app/public/'.$path);
        if (File::exists($legacyStorage)) {
            File::delete($legacyStorage);
        }
    }
}
