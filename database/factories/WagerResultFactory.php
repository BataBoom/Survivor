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
        // Use the state variable 'game' if it exists, otherwise use a random game
        $fetchGame = $this->state['game'] ?? WagerQuestion::WhereDoesntHave('result')->get()->random();

        // Ensure $fetchGame is not null before proceeding
        if ($fetchGame) {
            $winner = $fetchGame->gameoptions->first();
            //$winner = $fetchGame->gameoptions->random();

            if ($winner->home_team) {
                $scores = ['home' => rand(21, 48), 'away' => rand(7, 20)];
            } else {
                $scores = ['away' => rand(21, 48), 'home' => rand(7, 20)];
            }

            return [
                'game' => $fetchGame->game_id,
                'winner' => $winner->team_id,
                'winner_name' => $winner->option,
                'week' => $winner->week,
                'home_score' => $scores['home'],
                'away_score' => $scores['away'],
            ];
        }

        // Return default values if $fetchGame is null
        return [
            'game' => null,
            'winner' => null,
            'winner_name' => null,
            'week' => null,
            'home_score' => null,
            'away_score' => null,
        ];
    }


    public function game(int $game)
    {
        return $this->state(function (array $attributes) use ($game) {
            return [
                'game' => $game,
            ];
        });
    }
}
