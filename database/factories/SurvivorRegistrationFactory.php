<?php

namespace Database\Factories;

use App\Models\SurvivorRegistration;
use App\Models\Pool;
use App\Models\Survivor;
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

    public function configure()
    {
        return $this->afterCreating(function (SurvivorRegistration $survivorRegistration) {
           // $survivorRegistration->picks()->saveMany(Survivor::factory(['ticket_id' => $survivorRegistration->id])->count(5)->create());
        });
    }


}
