<?php

namespace Database\Seeders;

use App\Models\WagerResult;
use App\Models\WagerQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestWagerResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allGames = WagerQuestion::All();

        foreach($allGames as $game) {

            $randomSelection = $game->gameoptions->random();

            if ($randomSelection->home_team) {
                $scores = ['home' => rand(21, 48), 'away' => rand(7, 20)];
            } else {
                $scores = ['away' => rand(21, 48), 'home' => rand(7, 20)];
            }

            WagerResult::Create([
                'game' => $randomSelection->game_id,
                'winner' => $randomSelection->team_id,
                'winner_name' => $randomSelection->option,
                'week' => $game->week,
                'home_score' => $scores['home'],
                'away_score' => $scores['away'],
            ])->question()->update(['ended' => true, 'status' => true]);

        }
    }
}
