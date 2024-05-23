<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;
use App\Models\SurvivorRegistration;
use App\Models\Pool;
use Illuminate\Support\Facades\Config;

class FreshRegistrationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * New install Registration Event Handle the event.
     */
    public function handle(Registered $event): void
    {

        if($event->user->id === 1 && config::get('survivor.init.create_pickem_when_admin_registers')) {
            $pickem = Pool::Factory(['type' => 'pickem'])->create();
            SurvivorRegistration::Factory(['user_id' => $event->user->id, 'pool_id'=> $pickem->id]);
        } elseif($event->user->id !== 1 && config::get('survivor.init.add_future_users_to_first_pickem_pool')) {
            $pickem = Pool::Where('type', 'pickem')->first();
            SurvivorRegistration::Factory(['user_id' => $event->user->id, 'pool_id'=> $pickem->id]);
        }
    }
}
