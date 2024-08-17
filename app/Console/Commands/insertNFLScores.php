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

        $dateRanges = [
            ['start' => '2024-09-08', 'end' => '2024-09-12'],
            ['start' => '2024-09-13', 'end' => '2024-09-18'],
            ['start' => '2024-09-19', 'end' => '2024-09-25'],
            ['start' => '2024-09-26', 'end' => '2024-10-02'],
            ['start' => '2024-10-03', 'end' => '2024-10-09'],
            ['start' => '2024-10-10', 'end' => '2024-10-16'],
            ['start' => '2024-10-17', 'end' => '2024-10-21'],
            ['start' => '2024-10-22', 'end' => '2024-10-28'],
            ['start' => '2024-10-29', 'end' => '2024-11-06'],
            ['start' => '2024-11-07', 'end' => '2024-11-13'],
            ['start' => '2024-11-14', 'end' => '2024-11-20'],
            ['start' => '2024-11-21', 'end' => '2024-11-27'],
            ['start' => '2024-11-28', 'end' => '2024-12-04'],
            ['start' => '2024-12-05', 'end' => '2024-12-11'],
            ['start' => '2024-12-12', 'end' => '2024-12-19'],
            ['start' => '2024-12-20', 'end' => '2024-12-25'],
            ['start' => '2024-12-26', 'end' => '2024-12-31'],
            ['start' => '2025-01-01', 'end' => '2025-01-06'],
        ];

    $now = date('Y-m-d'); // Current date, can be customized
    $week = 1;
    foreach ($dateRanges as $i => $range) {
    if ($now >= $dateRanges[$i]['start'] && $now <= $dateRanges[$i]['end']) {
        $week = $i + 1;
    }
    }

        return $this->argument('week') ?? $week;
    }

    public function getGames() {

        $currentDatetime = Carbon::now()->addHours(4);
        $fetchGames = WagerQuestion::where("week", $this->getWeek())
        //->where('starts_at', '<', $currentDatetime->toDateTimeString())
        ->where('status', 0)
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

        $winnerName = WagerTeam::Where('team_id', $result)->pluck('name')->first();
        WagerQuestion::Where(['game_id' => $file[$i]['id']])->update(['status' => 1, 'ended' => 1]);
        WagerResult::Create([
        'game' => $file[$i]['id'],
        'winner' => $result,
        'winner_name' => $winnerName,
        'week' => $this->getWeek(),
        'home_score' => $teamA['score'],
        'away_score' => $teamB['score'],
        ]);

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
