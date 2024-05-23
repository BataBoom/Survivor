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
        $game = WagerQuestion::Where('week', 1)->get()->random();
        $selection = $game->gameoptions->random();
        //$pool = Pool::Where('type', 'survivor')->where('lives_per_person', 1)->first();

        return [
            'game_id' => $game->game_id,
            'user_id' => User::factory(),
            'selection' => $selection->option,
            'selection_id' => $selection->team_id,
            //'pool_id' => $pool->id,
            'ticket_id' => SurvivorRegistration::factory(),
            'week' => $game->week,
        ];
    }


}
