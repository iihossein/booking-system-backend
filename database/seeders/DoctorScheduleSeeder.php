<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // فرض می‌کنیم شما قبلاً دکترها را ایجاد کرده‌اید.
        $doctors = Doctor::all();

        // برای هر دکتر 3 زمان‌بندی ایجاد می‌شود.
        foreach ($doctors as $doctor) {
            DoctorSchedule::factory()->count(3)->create([
                'doctor_id' => $doctor->id,
            ]);
        }
    }
}
