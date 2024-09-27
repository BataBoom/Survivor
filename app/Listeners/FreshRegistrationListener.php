<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Registered;
use App\Models\SurvivorRegistration;
use App\Models\Pool;
use Illuminate\Support\Facades\Config;
use App\Mail\WelcomeEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Log;

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
     * Send welcome email + Add user to select pools, only after their email has been verified =]
     */
    public function handle(Verified $event): void
    {
        //$survivorPool = Pool::WhereNull('creator_id')->where('entry_cost', '0.0')->where('type', 'survivor')->firstOrFail();
        $pickemPool = Pool::WhereNull('creator_id')->where('entry_cost', '0.0')->where('type', 'pickem')->firstOrFail();

        $pickemPool->registration()->create(['user_id' => $event->user->id, 'lives_count' => 100]);
        //$survivorPool->registration()->create(['user_id' => $event->user->id, 'lives_count' => 1]);
        Mail::to($event->user->email)->send(new WelcomeEmail($event->user));

        /*
        if($event->user->id === 1 && config::get('survivor.init.create_pickem_when_admin_registers')) {
            $pickem = Pool::Factory(['type' => 'pickem'])->create();
            SurvivorRegistration::Factory(['user_id' => $event->user->id, 'pool_id'=> $pickem->id]);
        } elseif($event->user->id !== 1 && config::get('survivor.init.add_future_users_to_first_pickem_pool')) {
            $pickem = Pool::Where('type', 'pickem')->first();
            SurvivorRegistration::Factory(['user_id' => $event->user->id, 'pool_id'=> $pickem->id]);
        }
        */

    }
}
