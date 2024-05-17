<?php

namespace Database\Factories;

use App\Models\SurvivorRegistration;
use App\Models\Pool;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class SurvivorRegistrationFactory extends Factory
{
    protected $model = SurvivorRegistration::class;

    public function definition()
    {
        return [
            'user_id' => User::Factory(),
            'pool_id' => Pool::Factory(),
            'alive' => true,
           'lives_count' => 1,
        ];
    }


    /**
     * Configure the model factory.

    public function configure(): static
    {
        return $this->state(function (array $attributes) {
           //
        })->afterMaking(function (SurvivorRegistration $SurvivorRegistration) {
            //
        })->afterCreating(function (SurvivorRegistration $SurvivorRegistration) {

           // return $SurvivorRegistration->update(['lives_count' => $SurvivorRegistration->poolRegistration->lives_per_person ]);

        });
    }
     * */

}
