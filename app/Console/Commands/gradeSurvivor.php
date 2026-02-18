<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Survivor;
use App\Models\SurvivorRegistration;
use App\Models\WagerQuestion;
use App\Jobs\SurvivorGraded;
use Illuminate\Support\Facades\Log;
use App\Livewire\Traits\SurvivorTrait;

class gradeSurvivor extends Command
{
    use SurvivorTrait;

    /* BATABOOM */ 

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade:survivor {week?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'grade survivors picks';

    public function getWeek():int
    {
       return $this->argument('week') ?? $this->decipherWeek();
    }

    public function weekConcluded(): bool
    {
        return WagerQuestion::Where('week', $this->getWeek())->where('ended', false)->count() === 0 ? true : false;
    }
    
    
    public function newGrader()
    {

        $allPicks = Survivor::where('week', $this->getWeek())
                    ->whereHas('ticket', function ($query) {
                        $query->where('alive', true);
                    })
                    ->whereNull('result')
                    ->get();

        foreach ($allPicks as $pick) {

                if(is_null($pick->results) || !is_null($pick->result)) {
                continue;
                }

                if($pick->selection_id === $pick->results->winner) {
                    //user won outright
                    $pick->update(['result' => 1]);
		    
                    $this->line($pick->user->name.' moves on! Pick: '.$pick->selection);
                } elseif($pick->results->winner === 35)
                {
                    //game ended in tie, user moves on..
                    $pick->update(['result' => 1]);
	            
                    $this->line($pick->user->name.' moves on! Pick: '.$pick->selection);

                } elseif($pick->results->winner !== 35 && $pick->selection_id !== $pick->results->winner)
                {
                    //user lost outright
                    $pick->update(['result' => 0]);

                    //Kill the User
                    $pick->pool->update(['alive' => 0]);
		
		             $this->line($pick->user->name.' has been killed! Pick: '.$pick->selection);
                }

        }
    }
    public function survivorDidntPick()
    {
        $allSurvivors = SurvivorRegistration::SurvivorsAlive()
        ->where("pool_id", "9f55cf73-b4e6-4641-a24c-37e8b3d5f1cb")
        ->get();

        /* if theres only 1 survivor left/alive in a single pool, assume that pool has concluded and dont add them */
        $remainingSurvivors = $allSurvivors->groupBy('pool_id')->filter(function($group) {
            return $group->count() > 1;
        })->values()->flatten(1);

        foreach($remainingSurvivors as $survivorTicket) {
            if($survivorTicket->survivorPicks()->where('week', $this->getWeek())->doesntExist()) {
                $survivorTicket->update(['alive' => false]);
            }
        }

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         if($this->weekConcluded()) {
            $this->survivorDidntPick();
            $this->line('WEEK CONCLUDED!');
         } else {
            $this->line('WEEK NOT CONCLUDED!');
         }
         
         $this->newGrader();
    }
}