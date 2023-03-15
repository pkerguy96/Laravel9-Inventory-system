<?php

namespace Database\Factories;

use App\Models\notifications;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class NotificationsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = notifications::class;
    public function definition()
    {
        return [
            'product_id' => $this->faker->randomNumber(),
            'user_id' => 4,
            'is_read' => 0,
            'created_at' => now(),
            'message' => $this->faker->sentence(),

        ];
    }
}
