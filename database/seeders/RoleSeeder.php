<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role_administrator = Role::create(['name' => 'administrator']);
        $role_doctor = Role::create(['name' => 'doctor']);
        $role_patient = Role::create(['name' => 'patient']);
    }
}
