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

    public $game;

    public function definition()
    {
        $game = WagerQuestion::Where('week', $this->week)->get()->random();
        $selection = $game->gameoptions->random();
        //$pool = Pool::Where('type', 'survivor')->where('lives_per_person', 1)->first();

        return [
            'game_id' => $game->game_id,
            'user_id' => User::factory(),
            'selection' => $selection->option,
            'selection_id' => $selection->team_id,
            'ticket_id' => SurvivorRegistration::factory(),
            'week' => $game->week,
        ];
    }
/*
    public function exclusive(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'game_id' => $game->game_id,
                'user_id' => User::factory(),
                'selection' => $selection->option,
                'selection_id' => $selection->team_id,
                'ticket_id' => SurvivorRegistration::factory(),
                'week' => $game->week,
            ];
        })->afterMaking(function (Pool $pool) {
            // ...
        })->afterCreating(function (Pool $pool) {
            //
        });
    }
*/
}
