<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Models\Pool;

class UrgentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $poolLink;
    /**
     * Create a new message instance.
     */
    public function __construct(public User $user)
    {
        $this->user = $user;
        $this->poolLink = Route('pool.show', ['pool' => Pool::Where('name', 'Bravo')->first()->id]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            subject: "Coach ".ucwords($this->user->name).": You're alive! But we need a play on MNF!",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'emails.mnf',
            with: [
                'name' => ucwords($this->user->name),
                'email' => $this->user->email,
                'link' => $this->poolLink,
                'unsubscribelink' => route('unsubscribe', ['user' => $this->user->email]),
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
