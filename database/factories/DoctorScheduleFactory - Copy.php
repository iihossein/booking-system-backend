<?php

namespace Database\Factories;

use App\Models\Doctor;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DoctorSchedule>
 */
class DoctorScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // پیدا کردن اولین شنبه‌ی پیش رو
        $startDate = Carbon::now();
        while (!$startDate->isSaturday()) {
            $startDate->addDay();
        }

        // افزودن تعداد روز تصادفی بعد از شنبه (بدون جمعه)
        $startDate->addDays($this->faker->numberBetween(0, 5)); // حداکثر تا پنج‌شنبه

        // تنظیم زمان پایان ملاقات
        $endDate = (clone $startDate)->addHours($this->faker->numberBetween(1, 8));

        return [
            'doctor_id' => Doctor::inRandomOrder()->first()->id, // انتخاب دکتر به صورت تصادفی
            'start_time' => $startDate,
            'end_time' => $endDate,
            'appointment_duration' => $this->faker->numberBetween(10, 60),
        ];
    }
}
