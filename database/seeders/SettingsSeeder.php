<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            'site_name' => 'Suchana',
            'site_name_bn' => 'সুচনা',
            'tagline_bn' => 'দক্ষতাই শক্তি, প্রশিক্ষণই ভবিষ্যৎ',
            'tagline_en' => 'Skill is Power, Training is the Future',
            'phone' => '+880 1700-000000',
            'email' => 'help@suchana.bd',
            'address_bn' => 'ধানমন্ডি, ঢাকা, বাংলাদেশ',
            'address_en' => 'Dhanmondi, Dhaka, Bangladesh',
            'whatsapp_number' => '8801700000000',
            'facebook_url' => '',
            'youtube_url' => '',
            'instagram_url' => '',
            'live_chat_enabled' => '1',
            'live_chat_script' => '',
            'theme_color' => 'sky',
            'logo_suchana' => '',
            'logo_sfdb' => '',
            'hero_badge_bn' => 'ভর্তি চলছে | সরকারি অর্থায়নে বিনামূল্যে!',
            'hero_badge_en' => 'Admission Open | Free Under Govt Funding!',
            'about_bn' => 'সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট (SMTTI) সরকারি অর্থায়নে বিনামূল্যে দক্ষতা প্রশিক্ষণ প্রদান করে। আমাদের লক্ষ্য বেকার যুবক-যুবতীদের দক্ষ করে গড়ে তোলা।',
            'about_en' => 'Suchana Medical & Technical Training Institute (SMTTI) provides free skills training under government funding. Our goal is to make unemployed youth skilled.',
            'brand_title_bn' => 'সুচনা মেডিকেল এন্ড টেকনিক্যাল',
            'brand_title_en' => 'Suchana Medical & Technical',
            'hero_title_line1_bn' => 'দক্ষতাই শক্তি,',
            'hero_title_line1_en' => 'Skill is Power,',
            'hero_title_line2_bn' => 'প্রশিক্ষণই ভবিষ্যৎ',
            'hero_title_line2_en' => 'Training is the Future',
            'hero_subtitle_bn' => 'সুচনা মেডিকেল এন্ড টেকনিক্যাল ট্রেনিং ইনস্টিটিউট (SMTTI) — সরকারি অর্থায়নে বিনামূল্যে দক্ষতা প্রশিক্ষণ ও NSDA সনদ।',
            'hero_subtitle_en' => 'Suchana Medical & Technical Training Institute (SMTTI) — free government-funded skills training with NSDA certification.',
            'home_running_kicker_bn' => 'চলমান কোর্স',
            'home_running_kicker_en' => 'Running Courses',
            'home_running_title_bn' => 'চলমান কোর্সসমূহ',
            'home_running_title_en' => 'Running Courses',
            'home_running_lead_bn' => 'সরকারি অর্থায়নে বিনামূল্যে প্রশিক্ষণ — ভর্তি চলছে।',
            'home_running_lead_en' => 'Free government-funded training — admission open.',
            'home_courses_kicker_bn' => 'আমাদের কোর্স',
            'home_courses_kicker_en' => 'Our Courses',
            'home_courses_title_bn' => 'আমাদের কোর্সসমূহ',
            'home_courses_title_en' => 'Our Courses',
            'home_courses_lead_bn' => 'প্রতিটি কোর্সের মেয়াদ, যোগ্যতা, আসন, ফি, ভাতা ও আবেদনের সময়সীমা দেখুন।',
            'home_courses_lead_en' => 'See duration, eligibility, seats, fees, stipend and application deadline for each course.',
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
