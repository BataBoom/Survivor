<?php

namespace Database\Factories;

use App\Models\Pickem;
use App\Models\Pool;
use App\Models\SurvivorRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\WagerQuestion;

class PickemFactory extends Factory
{
    protected $model = Pickem::class;

    public function definition()
    {
        $game = WagerQuestion::Where('week', 3)->get()->random();
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

    public function pool(Pool $pool)
    {
        return $this->state(function (array $attributes) use ($pool) {
            return [
                'ticket_id' => SurvivorRegistration::factory()->pool($pool),
            ];
        });
    }


}