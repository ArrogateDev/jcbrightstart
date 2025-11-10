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

    /**
     * Create a new message instance.
     */
    public function __construct(VerificationCode $log)
    {
        $this->log = $log;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '聲享-註冊驗證碼',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $log = $this->log;
        $view = $log->scene === 'register' ? 'email.register' : 'email.forgot-password';
        return new Content(
            view: $view,
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
