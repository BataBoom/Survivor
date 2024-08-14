<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;
use App\Models\User;
use App\Models\TicketReply;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{

    protected $model = Ticket::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::Factory(),
            'subject' => fake()->sentence(6),
            'answered' => false,
            'resolved' => false,

        ];
     }

    public function withReplies(): Factory
    {

        return $this->afterCreating(function (Ticket $ticket) {
            $ticket->replies()
              ->saveMany(TicketReply::factory(['user_id' => $ticket->user_id])->count(rand(1,3))->create());
        });
    }

    public function answered(): static
    {
        return $this->state(fn (array $attributes) => [
            'answered' => true,
        ]);
    }

    public function resolved(): static
    {
        return $this->state(fn (array $attributes) => [
            'resolved' => true,
        ]);
    }
}
