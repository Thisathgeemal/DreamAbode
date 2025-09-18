<?php
namespace App\Mail;

use App\Models\ProjectAd;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProjectOwnerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $buyer;
    public $member;
    public $agent;
    public $project;

    /**
     * Create a new message instance.
     */
    public function __construct(User $buyer, User $member, User $agent, ProjectAd $project)
    {
        $this->buyer   = $buyer;
        $this->member  = $member;
        $this->agent   = $agent;
        $this->project = $project;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Project Owner Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.projectOwner',
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
