<?php
namespace App\Mail;

use App\Models\PropertyAd;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BuyerMail extends Mailable
{
    use Queueable, SerializesModels;

    public $buyer;
    public $member;
    public $agent;
    public $property;

    /**
     * Create a new message instance.
     */
    public function __construct(User $buyer, User $member, User $agent, PropertyAd $property)
    {
        $this->buyer    = $buyer;
        $this->member   = $member;
        $this->agent    = $agent;
        $this->property = $property;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Buyer Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.buyer',
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
