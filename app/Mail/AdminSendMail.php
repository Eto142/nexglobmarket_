<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminSendMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $mailSubject;
    public string $body;

    public function __construct(string $subject, string $body)
    {
        $this->mailSubject = $subject;
        $this->body        = $body;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_send',
            with: [
                'body' => $this->body,
            ],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
