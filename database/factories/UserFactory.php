<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $phone = $this->faker->phoneNumber;
        $nationalCode = $this->faker->unique()->numberBetween(1000000000, 9999999999);
        $gender = $this->faker->randomElement([0, 1]);
        $birthday = $this->faker->dateTimeBetween('-50 years', '-20 years');
        $status = $this->faker->boolean(1);
        $rememberToken = Str::random(10);

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'phone' => $phone,
            'password' => Hash::make('12345678'),
            'national_code' => $nationalCode,
            'gender' => $gender,
            'birthday' => $birthday,
            'status' => $status,
            'remember_token' => $rememberToken,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
