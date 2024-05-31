<?php

namespace App\Listeners;

use App\Events\SurvivorDiedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurvivorDied;

class SurvivorDiedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle User LOST a game on survivor (weekly basis) ONLY PASS LOSERS! Ensure the loser submitted a pick though otherwise skip them..
     */
    public function handle(SurvivorDiedEvent $event): void
    {
        Mail::to($event->survivor->user->email)->send(new SurvivorDied($event->survivor));
    }
}