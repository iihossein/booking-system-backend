<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Expertise;
use App\Models\User;
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
            'user_id' => 1, // ساخت یوزر جدید و مرتبط کردن با دکتر
            'expertise_id' => Expertise::inRandomOrder()->first()->id, // ساخت تخصص جدید و مرتبط کردن با دکتر
            'date_start_treatment' => $this->faker->dateTimeBetween('-30 years', 'now'), // تاریخ شروع درمان
            'address' => $this->faker->address, // آدرس تصادفی
            'latitude' => $this->faker->latitude, // طول جغرافیایی تصادفی
            'longitude' => $this->faker->longitude, // عرض جغرافیایی تصادفی
            'is_active' => $this->faker->boolean(90), // 90% شانس فعال بودن
        ];
    }
}
