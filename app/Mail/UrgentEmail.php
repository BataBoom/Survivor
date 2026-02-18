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
    public function __construct(public User $user, public int $week = 1)
    {
        $this->user = $user;
        $this->poolLink = Route('pool.show', ['pool' => Pool::Where('name', 'Cobra')->first()->id]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {

        return new Envelope(
            //subject: "Coach ".ucwords($this->user->name).": You're alive! But we need a play on MNF!",
             //subject: "Coach ".ucwords($this->user->name).": Your roster hasn't been finalized!",
            //subject: "Last Chance, Coach ".ucwords($this->user->name),
	   subject: "Coach ".ucwords($this->user->name).": Survivor pick unfinalized!",
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'emails.tie',
            //view: 'emails.mnf',
            //view: 'emails.urgent',
            with: [
                'name' => ucwords($this->user->name),
                'email' => $this->user->email,
                'link' => $this->poolLink,
                'week' => $this->week,
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
