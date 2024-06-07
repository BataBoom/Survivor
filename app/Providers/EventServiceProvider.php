<?php

namespace App\Providers;



use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Listeners\FreshRegistrationListener;
use App\Events\PoolCreated;
use App\Listeners\PoolCreatedListener;
use App\Events\IncomingPaymentEvent;
use App\Listeners\IncomingPaymentListener;
use App\Events\NewChatroomMessageEvent;
use Illuminate\Auth\Events\Verified;
use App\Listeners\SurvivorSubscriber;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [

        NewChatroomMessageEvent::class => [
            //
        ],
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        Verified::class => [
            FreshRegistrationListener::class,
        ],

        PoolCreated::class => [
            PoolCreatedListener::class
        ],

        IncomingPaymentEvent::class => [
            IncomingPaymentListener::class,
        ],

        NewChatroomMessageEvent::class => [
            //
        ],
    ];

    /**
     * The subscriber classes to register. These are Listeners, Inside these classes, provides the event
     *
     * @var array
     */
    protected $subscribe = [
        SurvivorSubscriber::class,
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
