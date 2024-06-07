<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Survivor;
use App\Models\SurvivorRegistration;
use App\Jobs\SurvivorGraded;
use Illuminate\Support\Facades\Log;

class gradeSurvivor extends Command
{

    /* BATABOOM */ 

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade:survivor {week}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'grade survivors picks';

    public function getWeek()
    {
        return $this->argument('week') ?? 'test';
    }

    public function newGrader()
    {
        $allPicks = Survivor::where('week', $this->getWeek())->get();

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

                    //Kill the User
                    $pick->pool->update(['alive' => 0]);
                }
        }
    }

    public function survivorDidntPick()
    {
        $allSurvivors = SurvivorRegistration::SurvivorsAlive()->get();

        foreach($allSurvivors as $survivorTicket) {
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
        $this->newGrader();
        $this->survivorDidntPick();
    }
}
