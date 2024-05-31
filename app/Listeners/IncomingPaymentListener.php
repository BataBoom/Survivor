<?php

namespace App\Listeners;

use App\Events\IncomingPaymentEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use App\Models\SurvivorRegistration;
use App\Mail\NewPaymentEmail;
use Illuminate\Support\Facades\Mail;

class IncomingPaymentListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle incoming payment
     * $event->type === 1 means User Paid for Pool, type 2 means Creator Paid for Pool
     */
    public function handle(IncomingPaymentEvent $event): void
    {
        log::debug('IncomingPaymentListener Fired!');

        //Locate Pool
        $pool = $event->payment->pool;
        //Create Ticket
        $myTicket = $pool->registration()->create(['user_id' => $event->payment->user_id, 'lives_count' => $pool->lives_per_person]);
        //Update Payment w/ Ticket
        $event->payment->update([
            'ticket_type' => 'App\Models\SurvivorRegistration',
            'ticket_id' => $myTicket->id,
        ]);

        if($event->type === 1) {

            //Send Success Email?
            Mail::to($event->payment->user->email)->send(new NewPaymentEmail($event->payment, $event->payment->user, 1));
        } elseif($event->type === 2) {

         $pool->update(['hidden' => false]);

            //Send Success Email?
            Mail::to($event->payment->user->email)->send(new NewPaymentEmail($event->payment, $event->payment->user, 2));

        }

    }
}
