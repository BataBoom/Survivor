<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\BetSlip;
use Illuminate\Database\Eloquent\Builder;

class gradeBetslips extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grade:betslips';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function moneylineBets()
    {
         return BetSlip::WhereNotNull('game_id')
                ->whereNull('result')
                ->whereHas('results')
                ->whereHas('type', function (Builder $query) {
                    $query->where('value', 'Moneyline');
                })
                ->get();
    }

    public function otherBets()
    {
        return BetSlip::WhereNotNull('game_id')
                ->whereNull('result')
                ->whereHas('results')
                ->whereHas('type', function (Builder $query) {
                    $query->where('value', '!==', 'Moneyline');
                })
                ->get();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        foreach($this->moneylineBets() as $bet) {
                if($bet->selection_id === $bet->results->winningTeam->id) {
                    $bet->update(['result' => 1]);
                } elseif($bet->selection_id !== $bet->results->winningTeam->id)
                {
                    $bet->update(['result' => 0]);
                }
        }
    }
}
