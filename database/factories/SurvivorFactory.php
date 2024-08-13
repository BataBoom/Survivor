<?php

namespace Database\Factories;

use App\Models\Survivor;
use App\Models\Pool;
use App\Models\SurvivorRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\WagerQuestion;

class SurvivorFactory extends Factory
{
    protected $model = Survivor::class;

    public function definition()
    {
        $week = $this->week ?? 1;

        $game = WagerQuestion::Where('week', $week)->get()->random();
        $selection = $game->gameoptions->random();

        return [
            'game_id' => $game->game_id,
            'user_id' => User::factory(),
            'selection' => $selection->option,
            'selection_id' => $selection->team_id,
            'ticket_id' => SurvivorRegistration::factory(),
            'week' => $game->week,
        ];
    }

    public function week(int $week)
    {
        return $this->state(function (array $attributes) use ($week) {
            return [
                'week' => $week,
            ];
        });
    }

    public function random(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'week' => 2,
            ];
        })->afterMaking(function (Survivor $pool) {
            // ...
        })->afterCreating(function (Survivor $pool) {
            // ...
        });

    }
}
