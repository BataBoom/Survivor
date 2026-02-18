<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PickemWinner extends Mailable
{
    use Queueable, SerializesModels;

    public const LINK = 'https://survivor.nbz.one/support/a0c523ba-74ce-48a9-88ab-7a986f0e7c2f';

    /**
     * Create a new message instance.
     */
    public function __construct(public User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        
	   $subject = 'NBZ Pickem Winner';

        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'emails.pickem_winner',
            with: [
                'coach' => ucfirst($this->user->name),
                'cash_out_link' => self::LINK,
            ],
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
