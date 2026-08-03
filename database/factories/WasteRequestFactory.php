<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\WasteRequest;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<WasteRequest>
 */
class WasteRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->citizen(),
            'collector_id' => null,
            'type' => fake()->randomElement(WasteRequest::TYPES),
            'weight' => fake()->randomFloat(2, 1, 50),
            'address' => fake()->address(),
            'description' => fake()->optional(0.7)->sentence(12),
            'image' => null,
            'status' => 'Pending',
        ];
    }

    public function accepted(): static
    {
        return $this->state(fn (array $attributes) => [
            'collector_id' => User::factory()->collector(),
            'status' => 'Accepted',
            'accepted_at' => now(),
        ]);
    }

    public function collected(): static
    {
        return $this->state(fn (array $attributes) => [
            'collector_id' => User::factory()->collector(),
            'status' => 'Collected',
            'accepted_at' => now()->subDays(2),
            'collected_at' => now(),
        ]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'Cancelled',
        ]);
    }
}
