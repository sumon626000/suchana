<?php

namespace App\Providers;

use App\Support\Settings;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        // Hostinger may miss `php artisan migrate`; keep certificate uploads safe.
        try {
            if (Schema::hasTable('certificates') && ! Schema::hasColumn('certificates', 'pdf_path')) {
                Schema::table('certificates', function (Blueprint $table) {
                    $table->string('pdf_path')->nullable()->after('status');
                });
            }
        } catch (\Throwable) {
            // Ignore during early boot / sqlite tests without table.
        }

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
                'hero_image' => Settings::get('hero_image', ''),
                'hero_image_url' => Settings::mediaUrl(Settings::get('hero_image', ''), asset('images/logo-suchana.jpg')),
                'hero_badge_bn' => Settings::get('hero_badge_bn', ''),
                'hero_badge_en' => Settings::get('hero_badge_en', ''),
                'about_bn' => Settings::get('about_bn', ''),
                'about_en' => Settings::get('about_en', ''),
                'brand_title_bn' => Settings::get('brand_title_bn', 'সুচনা মেডিকেল এন্ড টেকনিক্যাল'),
                'brand_title_en' => Settings::get('brand_title_en', 'Suchana Medical & Technical'),
                'brand_sub_bn' => Settings::get('brand_sub_bn', 'ট্রেনিং ইনস্টিটিউট (SMTTI)'),
                'brand_sub_en' => Settings::get('brand_sub_en', 'Training Institute (SMTTI)'),
                'hero_title_line1_bn' => Settings::get('hero_title_line1_bn', 'দক্ষতাই শক্তি,'),
                'hero_title_line1_en' => Settings::get('hero_title_line1_en', 'Skill is Power,'),
                'hero_title_line2_bn' => Settings::get('hero_title_line2_bn', 'প্রশিক্ষণই ভবিষ্যৎ'),
                'hero_title_line2_en' => Settings::get('hero_title_line2_en', 'Training is the Future'),
                'hero_subtitle_bn' => Settings::get('hero_subtitle_bn', 'সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট (SMTTI) — সরকারি অর্থায়নে বিনামূল্যে দক্ষতা প্রশিক্ষণ ও NSDA সনদ।'),
                'hero_subtitle_en' => Settings::get('hero_subtitle_en', 'Suchana Medical & Technical Training Institute (SMTTI) — free government-funded skills training with NSDA certification.'),
                'home_running_kicker_bn' => Settings::get('home_running_kicker_bn', 'চলমান কোর্স'),
                'home_running_kicker_en' => Settings::get('home_running_kicker_en', 'Running Courses'),
                'home_running_title_bn' => Settings::get('home_running_title_bn', 'চলমান কোর্সসমূহ'),
                'home_running_title_en' => Settings::get('home_running_title_en', 'Running Courses'),
                'home_running_lead_bn' => Settings::get('home_running_lead_bn', 'সরকারি অর্থায়নে বিনামূল্যে প্রশিক্ষণ — ভর্তি চলছে।'),
                'home_running_lead_en' => Settings::get('home_running_lead_en', 'Free government-funded training — admission open.'),
                'home_courses_kicker_bn' => Settings::get('home_courses_kicker_bn', 'আমাদের কোর্স'),
                'home_courses_kicker_en' => Settings::get('home_courses_kicker_en', 'Our Courses'),
                'home_courses_title_bn' => Settings::get('home_courses_title_bn', 'আমাদের কোর্সসমূহ'),
                'home_courses_title_en' => Settings::get('home_courses_title_en', 'Our Courses'),
                'home_courses_lead_bn' => Settings::get('home_courses_lead_bn', 'প্রতিটি কোর্সের মেয়াদ, যোগ্যতা, আসন, ফি, ভাতা ও আবেদনের সময়সীমা দেখুন।'),
                'home_courses_lead_en' => Settings::get('home_courses_lead_en', 'See duration, eligibility, seats, fees, stipend and application deadline for each course.'),
            ]);
        });
    }
}
