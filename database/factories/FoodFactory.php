<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Food>
 */
class FoodFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=> fake()->sentence(3),
            'price'=> fake()->numberBetween(1000, 3000),
            'size'=> fake()->numberBetween(1, 3),
            'category_id'=> fake()->numberBetween(1, 10),
            'img'=> fake()->imageUrl(600, 600, 'foods')
        ];
    }
}
