<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\WagerResult;
use App\Models\WagerTeam;
use App\Models\WagerOption;
use App\Models\WagerQuestion;
use Carbon\Carbon;

class insertNFLScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insert:nflscores {week?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'insert nfl scores';

    public function getWeek()
    {
        return $this->argument('week') ?? json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard'), true)['week']['number'];
    }

    public function getGames() {

        $fetchGames = WagerQuestion::where("week", $this->getWeek())
        //->where('status', 0)
        ->pluck('game_id');
        return $fetchGames;

    }

    public function lookup()
    {

        if($this->getGames()->isNotEmpty()) {

            foreach ($this->getGames() as $game)
            {

                $file[] = json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard/' . $game), true);
            }
        
        
        return $file;
        }

        
       
    }

    public function gradeIt()
    {

        if($this->lookup() !== null) {
        $file = $this->lookup();
        foreach ($file as $i => $game)
        {
            if(!$file[$i]['status']['type']['completed']) {
                $this->line('game hasnt finished! skipping');
                continue;
            }

        $gid = $file[$i]['id'];
        $step1 = $file[$i]['competitions'][0]['competitors'];
        $teamA = $step1[0];
        $teamB = $step1[1];

        if($teamA['winner']) {
        $result = $teamA['team']['id'];
        } elseif ($teamB['winner']) {
        $result = $teamB['team']['id'];
        } else {
        $result = 35;
        }

        $winnerName = WagerTeam::where('league', 'nfl')->Where('team_id', $result)->pluck('name')->first();
        $wagerQ = WagerQuestion::Where(['game_id' => $file[$i]['id']])->first();
        $wagerQ->update(['status' => 1, 'ended' => 1]);
        $wagerQ->result()->updateOrCreate(
        [
            'game' => $file[$i]['id']
        ],
        [
        'game' => $file[$i]['id'],
        'winner' => $result,
        'winner_name' => $winnerName,
        'week' => $this->getWeek(),
        'home_score' => $teamA['score'],
        'away_score' => $teamB['score'],
        ]
        );        
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
        $this->line("the week is: ".  $this->getWeek());

        return $this->gradeIt();
    }
}
