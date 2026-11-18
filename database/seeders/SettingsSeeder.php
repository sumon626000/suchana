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
        ];

        foreach ($defaults as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
