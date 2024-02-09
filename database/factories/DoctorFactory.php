<?php

namespace Database\Factories;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'national_code' => $this->faker->unique()->numberBetween(1000000000,9999999999),
            'expertise_id' => \App\Models\Expertise::inRandomOrder()->first()->id,
            'code' => $this->faker->unique()->numberBetween(10000000,99999999),
            'date_start_treatment' => $this->faker->dateTimeBetween('-20 year', '-2 year'),
            'gender' => $this->faker->randomElement([0, 1]),
            'birthday' => $this->faker->dateTimeBetween('-50 years', '-20 years'),
            'is_active' => $this->faker->boolean(1),
            'status' => $this->faker->boolean(1),
        ];
    }
}
