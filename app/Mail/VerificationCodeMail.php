<?php

namespace App\Mail;

use App\Models\VerificationCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class VerificationCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    private VerificationCode $log;

    private $templates = [
        'register' => [
            'subject' => '註冊驗證碼',
            'view' => 'email.register',
        ]
    ];

    public $template;

    /**
     * Create a new message instance.
     */
    public function __construct(VerificationCode $log)
    {
        $this->log = $log;
        $this->template = $this->templates[$log->scene];
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->template['subject'],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $log = $this->log;
        return new Content(
            view: $this->template['view'],
            with: [
                'account' => $log->account,
                'code' => $log->code,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
