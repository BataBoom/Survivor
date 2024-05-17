<?php

namespace Database\Factories;

use App\Models\WagerResult;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\WagerQuestion;

class WagerResultFactory extends Factory
{
    protected $model = WagerResult::class;

    public function definition()
    {
        $game = WagerQuestion::Scheduled()->random();
        $winner = $game->gameoptions->random();

        if ($winner->home_team) {
            $scores = ['home' => rand(21, 48), 'away' => rand(7, 20)];
        } else {
            $scores = ['away' => rand(21, 48), 'home' => rand(7, 20)];
        }

        return [
            'game' => $game->game_id,
            'winner' => $winner->team_id,
            'winner_name' => $winner->option,
            'week' => $winner->week,
            'home_score' => $scores['home'],
            'away_score' => $scores['away'],
        ];
    }



    /*
    public function definition()
    {
        // Default definition if no game is passed
        $game = WagerQuestion::Scheduled()->random();
        return $this->generateAttributes($game);
    }

    public function withGame(WagerQuestion $game)
    {
        return $this->state(function (array $attributes) use ($game) {
            return $this->generateAttributes($game);
        });
    }

    private function generateAttributes(WagerQuestion $game)
    {
        $winner = $game->gameoptions->random();

        if ($winner->home_team) {
            $scores = ['home' => rand(21, 48), 'away' => rand(7, 20)];
        } else {
            $scores = ['away' => rand(21, 48), 'home' => rand(7, 20)];
        }

        return [
            'game' => $game->game_id,
            'winner' => $winner->team_id,
            'winner_name' => $winner->option,
            'week' => $winner->week,
            'home_score' => $scores['home'],
            'away_score' => $scores['away'],
        ];
    }
    */
}
