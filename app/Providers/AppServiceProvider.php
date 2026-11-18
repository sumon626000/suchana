<?php

namespace App\Providers;

use App\Support\Settings;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('site', [
                'name' => Settings::get('site_name', 'Suchana'),
                'name_bn' => Settings::get('site_name_bn', 'সুচনা'),
                'tagline_bn' => Settings::get('tagline_bn', ''),
                'tagline_en' => Settings::get('tagline_en', ''),
                'phone' => Settings::get('phone', ''),
                'email' => Settings::get('email', ''),
                'address_bn' => Settings::get('address_bn', ''),
                'address_en' => Settings::get('address_en', ''),
                'whatsapp_number' => Settings::get('whatsapp_number', ''),
                'facebook_url' => Settings::get('facebook_url', ''),
                'youtube_url' => Settings::get('youtube_url', ''),
                'instagram_url' => Settings::get('instagram_url', ''),
                'live_chat_enabled' => Settings::bool('live_chat_enabled', false),
                'live_chat_script' => Settings::get('live_chat_script', ''),
                'theme_color' => Settings::get('theme_color', 'sky'),
                'logo_suchana' => Settings::get('logo_suchana', ''),
                'logo_sfdb' => Settings::get('logo_sfdb', ''),
                'hero_badge_bn' => Settings::get('hero_badge_bn', ''),
                'hero_badge_en' => Settings::get('hero_badge_en', ''),
                'about_bn' => Settings::get('about_bn', ''),
                'about_en' => Settings::get('about_en', ''),
            ]);
        });
    }
}
