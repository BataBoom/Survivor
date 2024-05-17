<?php

namespace Database\Seeders;

use App\Models\WagerResult;
use App\Models\WagerQuestion;
use App\Models\WagerTeam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WagerResultTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fetchGames = $this->getGames();
        foreach ($fetchGames as $game)
        {
            $file = json_decode(file_get_contents('https://site.api.espn.com/apis/site/v2/sports/football/nfl/scoreboard/' . $game), true);

            $gid = $file['id'];
            $step1 = $file['competitions'][0]['competitors'];
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
            WagerQuestion::Where(['game_id' => $file['id']])->update(['status' => 1]);
            WagerResult::Create([
                'game' => $game,
                'winner' => $result,
                'winner_name' => $winnerName,
                'week' => $file['week']['number'],
                'home_score' => $teamA['score'],
                'away_score' => $teamB['score'],
            ])->question()->update(['ended' => true, 'status' => true]);
                //->survivor()->update(['result' => ])


        }
    }

    public function getGames() {

        return WagerQuestion::where("week", '<', 3)
            ->where('status', 0)
            ->pluck('game_id');

    }
}
