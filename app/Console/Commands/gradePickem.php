<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pickem;
use App\Models\WagerResult;
use Illuminate\Support\Facades\Log;
use App\Livewire\Traits\SurvivorTrait;

class gradePickem extends Command
{
    use SurvivorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade:pickem {week?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'grade pickem picks';

    public function getWeek(): int 
    {
        return $this->argument('week') ?? $this->decipherWeek();
    }

    public function newGrader()
    {   

        $allPicks = Pickem::where('week', $this->getWeek())->WhereNull('result')->get();

            foreach ($allPicks as $pick) {
                
                if($pick->results === null) {
                continue;
                }

                if($pick->selection_id === $pick->results->winner) {
                    //user won outright
                    $pick->update(['result' => 1]);
                } elseif($pick->selection_id === 35)
                {
                    //game ended in tie, user moves on..
                    $pick->update(['result' => 1]);

                } elseif($pick->selection_id !== 35 && $pick->selection_id !== $pick->results->winner)
                {
                    //user lost outright
                    $pick->update(['result' => 0]);
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

        //$this->line($this->getWeek());
        return $this->newGrader();

    }
}
