<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([UserSeeder::class]);
        $this->call([ExpertiseSeeder::class]);
        $this->call([DoctorSeeder::class]);
        $this->call([DoctorScheduleSeeder::class]);
        $this->call([ReviewSeeder::class]);
        $this->call([RoleSeeder::class]);
    }
}
