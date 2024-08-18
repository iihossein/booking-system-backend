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
    protected $description = 'Artisan command to generate weekly appointments';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // دریافت تاریخ‌های هفته قبل
        $lastWeekStart = Carbon::now()->previous('Saturday')->startOfDay();
        $lastWeekEnd = $lastWeekStart->copy()->addDays(6)->endOfDay();

        // پیدا کردن و تغییر وضعیت نوبت‌های هفته قبل به Expired
        Appointment::whereBetween('appointment_date_time', [$lastWeekStart, $lastWeekEnd])
            ->update(['status' => 'Expired']);

        // دریافت تاریخ‌های هفته آینده
        $nextWeekStart = Carbon::now()->next('Saturday')->startOfDay();
        $nextWeekEnd = $nextWeekStart->copy()->addDays(6)->endOfDay();

        // دریافت همه‌ی اسکجول‌های پزشکان
        $schedules = DoctorSchedule::all();

        foreach ($schedules as $schedule) {
            // زمان شروع و پایان روز مربوطه
            $dayOfWeek = $nextWeekStart->copy()->next($schedule->day_of_week);
            $startTime = Carbon::parse($dayOfWeek->format('Y-m-d') . ' ' . $schedule->start_time);
            $endTime = Carbon::parse($dayOfWeek->format('Y-m-d') . ' ' . $schedule->end_time);

            // دریافت duration از اسکجول پزشک
            $appointmentDuration = $schedule->appointment_duration;

            // dd($startTime->format('Y-m-d H:i:s'));
            // تولید نوبت‌ها در بازه‌ی زمانی مشخص شده
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

        echo ('Weekly appointments generated successfully.');
    }
}
