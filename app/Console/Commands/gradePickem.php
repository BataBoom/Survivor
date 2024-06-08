<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pickem;
use App\Models\WagerResults;
use Illuminate\Support\Facades\Log;

class gradePickem extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade:pickem {week}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'grade pickem picks';

    public function getWeek()
    {
        return $this->argument('week') ?? 1;
    }

    public function newGrader()
    {   

        /* Works perfect, just to be safe use Pool 1 but thinking how to make that better, regardless fantastic refactor! */
        $allPicks = Pickem::where('week', $this->getWeek())->get();

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
        return $this->newGrader();

    }
}
