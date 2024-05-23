<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\User;
use App\Models\Pool;
use App\Models\SurvivorRegistration;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'payment_type' => Payment::TYPE[0],
            'pool_id' => Pool::factory(),
            //'ticket_id' => SurvivorRegistration::factory(),
            'paid' => false,
            'payment_id' => null,
            'amount_usd' => rand(5,250),
            'amount_crypto' =>  $this->faker->randomFloat(8, 0, 1),
        ];
    }
}
