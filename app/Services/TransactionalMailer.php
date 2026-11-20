<?php

namespace App\Services;

use App\Mail\SiteMessageMail;
use App\Models\Application;
use App\Models\Certificate;
use App\Models\Notice;
use App\Models\NotificationLog;
use App\Models\NotificationTemplate;
use App\Models\SupportMessage;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class TransactionalMailer
{
    /** @var array<string, string> */
    private const STATUS_BN = [
        'pending' => 'অপেক্ষমাণ',
        'verified' => 'যাচাইকৃত',
        'approved' => 'অনুমোদিত',
        'cancelled' => 'বাতিল',
        'waitlist' => 'ওয়েটলিস্ট',
    ];

    public function applicationReceived(Application $application): void
    {
        $application->loadMissing('course');

        $this->sendTemplateOrFallback(
            key: 'application_received',
            to: $application->email,
            fallbackSubject: 'আবেদন গ্রহণ হয়েছে — '.$application->application_no,
            fallbackBody: "প্রিয় {$application->full_name},\n\nসুচনা SMTTI-তে আপনার আবেদন সফলভাবে জমা হয়েছে।\nআবেদন নং: {$application->application_no}\nকোর্স: ".($application->course?->name_bn ?? '—')."\n\nস্ট্যাটাস ট্র্যাক করতে সাইটে আবেদন নম্বর ব্যবহার করুন।",
            vars: $this->applicationVars($application),
        );

        $admin = $this->adminEmail();
        if ($admin && strcasecmp($admin, (string) $application->email) !== 0) {
            $this->sendRaw(
                to: $admin,
                subject: 'নতুন আবেদন — '.$application->application_no,
                body: "নতুন আবেদন এসেছে।\n\nনাম: {$application->full_name}\nমোবাইল: {$application->mobile}\nইমেইল: {$application->email}\nআবেদন নং: {$application->application_no}\nকোর্স: ".($application->course?->name_bn ?? '—')."\nজেলা/থানা: {$application->district} / {$application->thana}\n\nঅ্যাডমিন প্যানেল থেকে রিভিউ করুন।",
                templateKey: 'application_received_admin',
            );
        }
    }

    public function applicationStatusChanged(Application $application): void
    {
        $application->loadMissing('course');
        $status = $application->status;
        $statusBn = self::STATUS_BN[$status] ?? $status;

        $fallbackBodies = [
            'pending' => "প্রিয় {$application->full_name},\n\nআপনার আবেদন ({$application->application_no}) এখন অপেক্ষমাণ অবস্থায় আছে।",
            'verified' => "প্রিয় {$application->full_name},\n\nআপনার আবেদন ({$application->application_no}) যাচাই হয়েছে। পরবর্তী নির্দেশনার জন্য অপেক্ষা করুন।",
            'approved' => "অভিনন্দন {$application->full_name}!\n\nআপনার আবেদন ({$application->application_no}) অনুমোদিত হয়েছে।\nকোর্স: ".($application->course?->name_bn ?? '—'),
            'cancelled' => "প্রিয় {$application->full_name},\n\nদুঃখিত, আপনার আবেদন ({$application->application_no}) বাতিল হয়েছে।".($application->rejection_reason ? "\nকারণ: {$application->rejection_reason}" : ''),
            'waitlist' => "প্রিয় {$application->full_name},\n\nআপনার আবেদন ({$application->application_no}) ওয়েটলিস্টে রাখা হয়েছে। সিট খালি হলে জানানো হবে।",
        ];

        $this->sendTemplateOrFallback(
            key: 'status_'.$status,
            to: $application->email,
            fallbackSubject: "আবেদন {$statusBn} — {$application->application_no}",
            fallbackBody: $fallbackBodies[$status] ?? "প্রিয় {$application->full_name},\n\nআপনার আবেদন ({$application->application_no}) এর নতুন স্ট্যাটাস: {$statusBn}",
            vars: $this->applicationVars($application),
        );
    }

    public function userRegistered(User $user): void
    {
        if (! $user->email) {
            return;
        }

        $this->sendRaw(
            to: $user->email,
            subject: 'স্বাগতম — সুচনা SMTTI',
            body: "প্রিয় {$user->name},\n\nসুচনা SMTTI-তে রেজিস্ট্রেশন সফল হয়েছে।\nইউজারনেম: {$user->username}\n\nএখন লগইন করে কোর্সে আবেদন করতে পারেন।\nওয়েবসাইট: ".config('app.url'),
            templateKey: 'user_registered',
        );
    }

    public function certificateIssued(Certificate $certificate): void
    {
        $certificate->loadMissing(['user', 'course']);
        $user = $certificate->user;

        if (! $user?->email) {
            return;
        }

        $course = $certificate->course?->name_bn ?? '—';
        $verifyUrl = route('verify.code', $certificate->verification_code);

        $this->sendTemplateOrFallback(
            key: 'certificate_issued',
            to: $user->email,
            fallbackSubject: 'আপনার সার্টিফিকেট তৈরি হয়েছে',
            fallbackBody: "প্রিয় {$user->name},\n\nআপনার {$course} কোর্সের সার্টিফিকেট তৈরি হয়েছে।\nসার্টিফিকেট নং: {$certificate->certificate_no}\nভেরিফিকেশন: {$verifyUrl}",
            vars: [
                '{name}' => $user->name,
                '{app_no}' => '',
                '{course}' => $course,
                '{status}' => 'issued',
                '{cert_no}' => $certificate->certificate_no,
            ],
        );
    }

    public function supportMessageReceived(SupportMessage $message): void
    {
        $admin = $this->adminEmail();
        if (! $admin) {
            return;
        }

        $this->sendRaw(
            to: $admin,
            subject: 'নতুন সাপোর্ট মেসেজ — '.$message->name,
            body: "সাইট থেকে নতুন সাপোর্ট মেসেজ এসেছে।\n\nনাম: {$message->name}\nমোবাইল: {$message->mobile}\n\nবার্তা:\n{$message->message}",
            templateKey: 'support_message',
        );
    }

    public function noticePublished(Notice $notice): int
    {
        if (! $notice->is_active) {
            return 0;
        }

        $url = route('notices.index');
        $bodyText = trim((string) $notice->body_bn);
        $sent = 0;

        User::query()
            ->where('is_active', true)
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->orderBy('id')
            ->chunkById(50, function ($users) use ($notice, $url, $bodyText, &$sent): void {
                foreach ($users as $user) {
                    $body = "প্রিয় {$user->name},\n\nসুচনা SMTTI-তে নতুন নোটিশ প্রকাশিত হয়েছে।\n\n{$notice->title_bn}";
                    if ($bodyText !== '') {
                        $body .= "\n\n{$bodyText}";
                    }
                    $body .= "\n\nবিস্তারিত দেখুন: {$url}";

                    $this->sendRaw(
                        to: $user->email,
                        subject: 'নতুন নোটিশ — '.$notice->title_bn,
                        body: $body,
                        templateKey: 'notice_published',
                    );
                    $sent++;
                }
            });

        return $sent;
    }

    /**
     * @param  array<string, string>  $vars
     */
    private function sendTemplateOrFallback(string $key, ?string $to, string $fallbackSubject, string $fallbackBody, array $vars): void
    {
        if (! $to) {
            return;
        }

        $template = NotificationTemplate::query()
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        $subject = $fallbackSubject;
        $body = $fallbackBody;

        if ($template && in_array($template->channel, ['email', 'both'], true)) {
            $subject = $template->subject ?: $fallbackSubject;
            $body = str_replace(array_keys($vars), array_values($vars), $template->body_bn);
        } elseif ($template && $template->channel === 'sms') {
            // Prefer email delivery for critical updates even if legacy channel was SMS.
            $body = str_replace(array_keys($vars), array_values($vars), $template->body_bn);
            $subject = $template->subject ?: $fallbackSubject;
        }

        $this->sendRaw($to, $subject, $body, $key);
    }

    private function sendRaw(string $to, string $subject, string $body, string $templateKey): void
    {
        $status = 'sent';

        try {
            Mail::to($to)->send(new SiteMessageMail($subject, $body));
        } catch (Throwable $e) {
            $status = 'failed';
            Log::warning('transactional_mail.failed', [
                'template' => $templateKey,
                'to' => $to,
                'message' => $e->getMessage(),
            ]);
        }

        NotificationLog::create([
            'template_key' => $templateKey,
            'channel' => 'email',
            'recipient' => $to,
            'message' => $body,
            'status' => $status,
        ]);
    }

    /** @return array<string, string> */
    private function applicationVars(Application $application): array
    {
        return [
            '{name}' => $application->full_name,
            '{app_no}' => $application->application_no,
            '{course}' => $application->course?->name_bn ?? '',
            '{status}' => self::STATUS_BN[$application->status] ?? $application->status,
            '{cert_no}' => '',
        ];
    }

    private function adminEmail(): ?string
    {
        $email = Settings::get('email', config('mail.from.address'));

        return is_string($email) && filter_var($email, FILTER_VALIDATE_EMAIL) ? $email : null;
    }
}
