<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Payment;
use App\Models\Pool;

class NewPaymentEmail extends Mailable
{
    use Queueable, SerializesModels;

    public Pool $pool;

    /**
     * Create a new message instance.
     */
    public function __construct(public Payment $payment, public User $user, public int $type)
    {
        $this->user = $user;
        $this->payment = $payment;
        $this->type = $type;
        $this->pool = $this->payment->ticket->pool;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        if($this->type == 1) {
            $subject = "Contract Landed, You're in! Pool: ".$this->payment->ticket->pool->name;
        } elseif($this->type == 2) {
            $subject = "Contract paid! Your league has been setup.";
        } else {
            $subject = "Payment Received! | Survivor";
        }
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
            view: 'emails.new-payment',
            with: [
                'name' => $this->user->name,
                'pool' => $this->pool,
                'payment' => $this->payment,
                'user' => $this->user,
                'type' => ($this->type == 1) ? 'user' : 'admin',
               // 'entry_cost' => $this->pool->entry_cost,
                //'total_prize' => $this->pool->total_prize,
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