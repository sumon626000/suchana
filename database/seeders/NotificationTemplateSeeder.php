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
                'channel' => 'sms',
                'body_bn' => 'প্রিয় {name}, সুচনা SMTTI-তে আপনার আবেদন ({app_no}) গ্রহণ করা হয়েছে। কোর্স: {course}।',
                'body_en' => 'Dear {name}, your application ({app_no}) has been received. Course: {course}.',
            ],
            [
                'key' => 'status_pending',
                'channel' => 'sms',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন ({app_no}) অপেক্ষমাণ অবস্থায় আছে। শীঘ্রই যোগাযোগ করা হবে।',
                'body_en' => 'Dear {name}, your application ({app_no}) is pending review.',
            ],
            [
                'key' => 'status_verified',
                'channel' => 'sms',
                'body_bn' => 'প্রিয় {name}, আপনার আবেদন ({app_no}) যাচাই হয়েছে। interview-এর জন্য অপেক্ষা করুন।',
                'body_en' => 'Dear {name}, your application ({app_no}) has been verified.',
            ],
            [
                'key' => 'status_approved',
                'channel' => 'sms',
                'body_bn' => 'অভিনন্দন {name}! আপনার আবেদন ({app_no}) অনুমোদিত হয়েছে। কোর্স: {course}।',
                'body_en' => 'Congratulations {name}! Your application ({app_no}) is approved. Course: {course}.',
            ],
            [
                'key' => 'status_cancelled',
                'channel' => 'sms',
                'body_bn' => 'প্রিয় {name}, দুঃখিত, আপনার আবেদন ({app_no}) বাতিল হয়েছে।',
                'body_en' => 'Dear {name}, your application ({app_no}) has been cancelled.',
            ],
            [
                'key' => 'certificate_issued',
                'channel' => 'email',
                'subject' => 'আপনার সার্টিফিকেট তৈরি হয়েছে',
                'body_bn' => 'প্রিয় {name}, আপনার {course} কোর্সের সার্টিফিকেট তৈরি হয়েছে। সার্টিফিকেট নং: {cert_no}।',
                'body_en' => 'Dear {name}, your certificate for {course} is ready. Certificate no: {cert_no}.',
            ],
        ];

        foreach ($rows as $row) {
            NotificationTemplate::updateOrCreate(
                ['key' => $row['key']],
                $row + ['subject' => $row['subject'] ?? null, 'is_active' => true]
            );
        }
    }
}
