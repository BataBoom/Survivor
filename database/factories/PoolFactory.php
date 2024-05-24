<?php

namespace Database\Factories;

use App\Models\Pool;
use App\Models\SurvivorRegistration;
use App\Models\Survivor;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
class PoolFactory extends Factory
{
    protected $model = Pool::class;

    public array $type = ['survivor', 'pickem', 'testing'];

    public function definition()
    {

        return [
            'name' => fake()->name(),
            'type' => $this->type[0],
            'entry_cost' => rand(0,100),
            'status' => true,
            'lives_per_person' => rand(1,3),
        ];
    }

    public function single(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'lives_per_person' => 1,
                'type' => $this->type[0],
            ];
        })->afterMaking(function (Pool $pool) {
            // ...
        })->afterCreating(function (Pool $pool) {
           //
        });
    }

    public function pickem(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'lives_per_person' => 100,
                'type' => $this->type[1],
            ];
        })->afterMaking(function (Pool $pool) {
            // ...
        })->afterCreating(function (Pool $pool) {
            //
        });
    }

    public function hasCreator(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'creator_id' => User::factory(),
            ];
        });
    }
/*
    public function configure()
    {
        return $this->afterCreating(function (Pool $pool) {
            $pool->contenders()
                ->saveMany(SurvivorRegistration::factory(['pool_id' => $pool->id])->count(5)->create());
        });
    }
*/
    public function survivor(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'lives_per_person' => 1,
                'type' => $this->type[0],
            ];
        })->afterMaking(function (Pool $pool) {
            // ...
        })->afterCreating(function (Pool $pool) {
            $registrations = SurvivorRegistration::factory(['pool_id' => $pool->id])
                ->count(2)
                ->create();
            /*
          * Moved this part to seeder SimulateSeasonSeeder... for now
          $registrations->each(function ($registration) {
              $registration->tickets()->create(Survivor::factory(['ticket_id' => $registration->id])->raw());
          });
          */

            $pool->contenders()->saveMany($registrations);
        });
    }

}
