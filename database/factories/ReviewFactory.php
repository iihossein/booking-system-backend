<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reviews>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id, // فرض بر این است که شما یک فکتوری برای User دارید
            'doctor_id' => Doctor::inRandomOrder()->first()->id, // فرض بر این است که شما یک فکتوری برای Doctor دارید
            'text' => $this->faker->sentence(),
            'rate' => $this->faker->numberBetween(1, 5), // نمره بین 1 تا 5
            'is_accepted' => $this->faker->boolean(),
        ];
    }
}
