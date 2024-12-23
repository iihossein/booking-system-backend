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

        $dayOfWeek = $this->faker->randomElement(['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday']);
        $nextWeekStart = Carbon::now()->next('Saturday')->startOfDay();
        $scheduleDate = $nextWeekStart->copy()->next($dayOfWeek)->format('Y-m-d');

        $daysOfWeek = ['Saturday', 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday'];

        $appointment_durations = [10, 20, 30, 60];

        $costs = [90000,120000,200000,350000];

        return [
            'day_of_week' => $this->faker->randomElement($daysOfWeek),
            'schedule_date' => $scheduleDate,
            'start_time' => '08:00:00',
            'end_time' => '17:00:00',
            'appointment_duration' => $this->faker->randomElement($appointment_durations),
            'cost' => $this->faker->randomElement($costs),
        ];
    }
}
