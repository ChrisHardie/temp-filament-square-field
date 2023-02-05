<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscription>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subscriber_name' => fake()->name(),
            'start_at' => fake()->date(),
            'end_at' => fake()->date(),
            'amount' => fake()->numberBetween(1, 55),
        ];
    }
}
