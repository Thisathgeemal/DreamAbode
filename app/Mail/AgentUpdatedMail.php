<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AgentUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $defaultPassword;

    public function __construct($user, $defaultPassword)
    {
        $this->user            = $user;
        $this->defaultPassword = $defaultPassword;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your DreamAbode Account Details Have Been Updated',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.agentUpdate',
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
