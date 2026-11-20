<?php

namespace Database\Seeders;

use App\Models\NotificationTemplate;
use Illuminate\Database\Seeder;

class NotificationTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $rows = [
            [
                'key' => 'application_received',
                'channel' => 'email',
                'subject' => 'আবেদন গ্রহণ হয়েছে — সুচনা SMTTI',
                'body_bn' => "প্রিয় {name},\n\nসুচনা SMTTI-তে আপনার আবেদন গ্রহণ করা হয়েছে।\nআবেদন নং: {app_no}\nকোর্স: {course}\n\nস্ট্যাটাস ট্র্যাক করতে সাইটে আবেদন নম্বর ব্যবহার করুন।",
                'body_en' => 'Dear {name}, your application ({app_no}) has been received. Course: {course}.',
            ],
            [
                'key' => 'status_pending',
                'channel' => 'email',
                'subject' => 'আবেদন অপেক্ষমাণ — সুচনা SMTTI',
                'body_bn' => "প্রিয় {name},\n\nআপনার আবেদন ({app_no}) অপেক্ষমাণ অবস্থায় আছে। শীঘ্রই যোগাযোগ করা হবে।\nকোর্স: {course}",
                'body_en' => 'Dear {name}, your application ({app_no}) is pending review.',
            ],
            [
                'key' => 'status_verified',
                'channel' => 'email',
                'subject' => 'আবেদন যাচাই হয়েছে — সুচনা SMTTI',
                'body_bn' => "প্রিয় {name},\n\nআপনার আবেদন ({app_no}) যাচাই হয়েছে। পরবর্তী নির্দেশনার জন্য অপেক্ষা করুন।\nকোর্স: {course}",
                'body_en' => 'Dear {name}, your application ({app_no}) has been verified.',
            ],
            [
                'key' => 'status_approved',
                'channel' => 'email',
                'subject' => 'আবেদন অনুমোদিত — সুচনা SMTTI',
                'body_bn' => "অভিনন্দন {name}!\n\nআপনার আবেদন ({app_no}) অনুমোদিত হয়েছে।\nকোর্স: {course}",
                'body_en' => 'Congratulations {name}! Your application ({app_no}) is approved. Course: {course}.',
            ],
            [
                'key' => 'status_cancelled',
                'channel' => 'email',
                'subject' => 'আবেদন বাতিল — সুচনা SMTTI',
                'body_bn' => "প্রিয় {name},\n\nদুঃখিত, আপনার আবেদন ({app_no}) বাতিল হয়েছে।\nকোর্স: {course}",
                'body_en' => 'Dear {name}, your application ({app_no}) has been cancelled.',
            ],
            [
                'key' => 'status_waitlist',
                'channel' => 'email',
                'subject' => 'আবেদন ওয়েটলিস্ট — সুচনা SMTTI',
                'body_bn' => "প্রিয় {name},\n\nআপনার আবেদন ({app_no}) ওয়েটলিস্টে রাখা হয়েছে। সিট খালি হলে জানানো হবে।\nকোর্স: {course}",
                'body_en' => 'Dear {name}, your application ({app_no}) is on the waitlist.',
            ],
            [
                'key' => 'certificate_issued',
                'channel' => 'email',
                'subject' => 'আপনার সার্টিফিকেট তৈরি হয়েছে',
                'body_bn' => "প্রিয় {name},\n\nআপনার {course} কোর্সের সার্টিফিকেট তৈরি হয়েছে।\nসার্টিফিকেট নং: {cert_no}",
                'body_en' => 'Dear {name}, your certificate for {course} is ready. Certificate no: {cert_no}.',
            ],
        ];

        foreach ($rows as $row) {
            NotificationTemplate::updateOrCreate(
                ['key' => $row['key']],
                $row + ['is_active' => true]
            );
        }
    }
}
