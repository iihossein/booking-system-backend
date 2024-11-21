<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use App\Models\DoctorSchedule;
use Carbon\Carbon;
use Illuminate\Console\Command;

class GenerateWeeklyAppointments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'appointment:generate-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Artisan command to generate weekly appointments and update schedules dynamically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // دریافت تاریخ‌های هفته آینده
        $nextWeekStart = Carbon::now()->next('Saturday')->startOfDay();

        // دریافت همه‌ی اسکجول‌های پزشکان
        $schedules = DoctorSchedule::all();

        foreach ($schedules as $schedule) {
            // تاریخ داینامیک برای روز خاص هفته
            $scheduleDate = $nextWeekStart->copy()->next($schedule->day_of_week)->format('Y-m-d');

            // آپدیت ستون تاریخ در جدول زمان‌بندی
            $schedule->update([
                'schedule_date' => $scheduleDate,
            ]);

            // تولید نوبت‌ها مشابه کد قبلی
            $startTime = Carbon::parse($scheduleDate . ' ' . $schedule->start_time);
            $endTime = Carbon::parse($scheduleDate . ' ' . $schedule->end_time);
            $appointmentDuration = $schedule->appointment_duration;

            while ($startTime->lessThan($endTime)) {
                Appointment::create([
                    'doctor_id' => $schedule->doctor_id,
                    'doctor_schedule_id' => $schedule->id,
                    'appointment_date_time' => $startTime->format('Y-m-d H:i:s'),
                    'status' => 'Scheduled',
                ]);

                $startTime->addMinutes($appointmentDuration);
            }
        }

        // پیام موفقیت
        $this->info('Weekly appointments generated successfully.');
    }
}
