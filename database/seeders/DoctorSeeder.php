<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Office;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i < 31; $i++) {
            Doctor::factory()->count(1)->create([
                'user_id' => $i,
            ]);
        }
    }
}
