<?php

namespace App\Mail;

use App\Models\Survivor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TiedEmail extends Mailable
{
    use Queueable, SerializesModels;

    public array $gameResult;

    public bool $gameTied;

    /**
     * Create a new message instance.
     */
    public function __construct(public Survivor $survivor)
    {
        $this->survivor = $survivor;
        $this->gameTied = $this->survivor->results->winner === 35 ? true : false;
        
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        
	   $subject = 'Winner, Winner, Chicken Dinner!';

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
            view: 'emails.tie',
            with: [
                'name' => ucfirst($this->survivor->user->name),
                'survivor' => $this->survivor,
                'pool' => $this->survivor->pool->pool,
                'week' => $this->survivor->week,
                'email' => $this->survivor->user->email,
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
