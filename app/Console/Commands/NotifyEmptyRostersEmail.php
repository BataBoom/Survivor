<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\UrgentEmail;
use App\Models\User;
use App\Models\Pool;

class NotifyEmptyRostersEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:notify-empty-rosters';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preseason Email Notify Slackers';

    public function setup()
    {
        $contenders = Pool::Where('name', 'Bravo')->first()->contenders;
        $gogetters = collect();
        $contestants = collect();
        foreach ($contenders as $contender) {

          if($contender->picks->where('week', 1)->isEmpty()) {
            $contestants->push($contender);
          } else {
            $gogetters->push($contender);
          }
        }

        $await->count();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        
        $contenders = Pool::Where('name', 'Bravo')->first()->contenders;
        $gogetters = collect();
        $slackers = collect();

        foreach ($contenders as $contender) {

          if($contender->picks->where('week', 1)->isEmpty()) {
            $slackers->push($contender);
          } else {
            $gogetters->push($contender);
          }
        }
	 //$slackers = $slackers->skip(5);
        foreach($slackers as $slacker)
        {
//            $this->line('sending TEST TEST TEST email to: ' . $slacker->user->name);
            Mail::to($slacker->user->email)->send(new UrgentEmail($slacker->user));
        }

    //    $this->line('go getters count: '. $gogetters->count());
        $this->line('slacking contestants count: '. $slackers->count());

    }
}
