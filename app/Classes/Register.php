<?php

// Register.php

namespace App\Classes;

use App\Models\Doctor;
use App\Models\Office;
use Carbon\Carbon;
use App\Models\User;
use Hekmatinasser\Verta\Facades\Verta;
use Illuminate\Support\Facades\DB;

class Register
{
    public function registerNewUser(
        $role,
        $user_data,
        $doctor_data,
    ) {
        DB::beginTransaction();
        try {
            $user_data['birthday'] = Verta::parse("{$user_data['birthday']} 00:00:00")->toCarbon();
            $doctor_data['date_start_treatment'] = Verta::parse("{$doctor_data['date_start_treatment']}/01/01 00:00:00")->toCarbon();
            $user = User::where('phone', $user_data['phone'])->first();
            $user->update($user_data);
            // $user->assignRole($role);
            if ($role == 'doctor') {
                Doctor::create(array_merge($doctor_data, ['user_id' => $user->id]));
            }
            DB::commit();
            return $user;
        } catch (\Exception $e) {
            ddd($e);
            DB::rollBack();
            return false;
        }
    }
}