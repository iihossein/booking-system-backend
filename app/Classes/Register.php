<?php

namespace App\Classes;

use App\Models\User;
use Carbon\Carbon;

class Register
{
    public function registerNewUser(
        $first_name,
        $last_name,
        $phone,
        $password,
        $national_code,
        $gender,
        $birthday,
    ) {
        $user = User::where('phone', $phone)->first();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->phone = $phone;
        $user->password = $password;
        $user->national_code = $national_code;
        $user->gender = $gender;
        $user->birthday = $birthday = Carbon::now();


        if ($user->save()) {
            return $user;
        } else {
            return false;
        }
    }
}
