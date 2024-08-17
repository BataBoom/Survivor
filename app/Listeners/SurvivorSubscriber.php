<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Events\Dispatcher;
use App\Events\SurvivorGradedEvent;
use Illuminate\Support\Facades\Log;
use App\Mail\SurvivorTales;
use App\Mail\SurvivorDied;
use Illuminate\Support\Facades\Mail;

class SurvivorSubscriber implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Delete the job if its models no longer exist.
     *
     * @var bool
     */
    public $deleteWhenMissingModels = true;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @return array<string, string>
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            SurvivorGradedEvent::class => 'handleUpdated',
        ];
    }

    /**
     * Handle the event.
     */
    public function handleUpdated(SurvivorGradedEvent $event): void
    {
        
        if($event->survivor->user->subscribed && !is_null($event->survivor->results)) {
            if ($event->survivor->result === 1 && $event->survivor->results->winner !== 35) {
                Mail::to($event->survivor->user->email)->send(new SurvivorTales($event->survivor));
                Log::debug('Winner Event Called, UID:' . $event->survivor->user->id.' Week: '. $event->survivor->week);
            } elseif ($event->survivor->result === 1 && $event->survivor->results->winner === 35) {
                //User won, but barely, game ended in a tie. Send Success email but maybe add some splice.
                Mail::to($event->survivor->user->email)->send(new SurvivorTales($event->survivor));
            } elseif ($event->survivor->result === 0) {
                //User won, but barely, game ended in a tie. Send Success email but maybe add some splice.
                Mail::to($event->survivor->user->email)->send(new SurvivorDied($event->survivor));
                Log::debug('Loser Event Called, UID:' . $event->survivor->user->id.' Week: '. $event->survivor->week);
            }
        }

    }
}
