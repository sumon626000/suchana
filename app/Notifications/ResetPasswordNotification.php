<?php

namespace App\Notifications;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordNotification extends ResetPassword
{
    /**
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('সুচনা SMTTI — পাসওয়ার্ড রিসেট')
            ->line('আপনার অ্যাকাউন্টের জন্য পাসওয়ার্ড রিসেটের অনুরোধ করা হয়েছে।')
            ->action('নতুন পাসওয়ার্ড সেট করুন', $this->resetUrl($notifiable))
            ->line('এই লিংকটি ৬০ মিনিটের জন্য বৈধ।')
            ->line('আপনি অনুরোধ না করে থাকলে এই ইমেইল উপেক্ষা করুন।');
    }
}
