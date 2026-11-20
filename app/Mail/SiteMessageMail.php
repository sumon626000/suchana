<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SiteMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public string $bodyText,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subjectLine,
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: $this->htmlBody(),
        );
    }

    private function htmlBody(): string
    {
        $safe = nl2br(e($this->bodyText));

        return <<<HTML
        <div style="font-family:Segoe UI,Tahoma,Arial,sans-serif;font-size:15px;line-height:1.6;color:#122;max-width:560px">
          <p style="margin:0 0 12px;font-weight:700;color:#0a7a4b">Suchana SMTTI</p>
          <div>{$safe}</div>
          <p style="margin:22px 0 0;font-size:12px;color:#667">এটি স্বয়ংক্রিয় ইমেইল। প্রয়োজনে help@suchana.bd-এ যোগাযোগ করুন।</p>
        </div>
        HTML;
    }
}
