<?php

namespace App\Listeners;

use App\Events\SurvivedAWeekEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SurvivorTales;

class SurvivedAWeekEventListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle User won a game on survivor (weekly basis) ONLY PASS WINNERS!
     */
    public function handle(SurvivedAWeekEvent $event): void
    {
      Mail::to($event->survivor->user->email)->send(new SurvivorTales($event->survivor));
    }
}