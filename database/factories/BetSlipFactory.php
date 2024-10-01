<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\BetSlip;
use App\Models\WagerQuestion;
use App\Models\BetType;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BetSlip>
 */
class BetSlipFactory extends Factory
{
    protected $model = BetSlip::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $randomGame = WagerQuestion::Where('league', 'nfl')->inRandomOrder()->get()->first();

        $digits = 3;
        $sign = ['+', '-'];
        $odds = $sign[rand(0,1)].''.rand(pow(rand(6,9), $digits-1), pow(rand(6,9), $digits)-1);

        return [
            'user_id' => User::Factory(),
            'league_id' => 1,
            'sport' => 'NFL',
            'bet_type' => BetType::WhereIn('id', [1,2,3,4,5])->inRandomOrder()->first()->id,
            'game_id' => $randomGame->game_id,
            'selection_id' => $randomGame->gameoptions->random()->team->id,
            'odds' => $odds,
            'bet_amount' => floatval(mt_rand(100, 900)),
            'starts_at' => $randomGame->starts_at,
        ];
    }
}
