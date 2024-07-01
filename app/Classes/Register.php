<?php

namespace app\Classes;

use App\Models\User;

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
        $user = new User();
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->phone = $phone;
        $user->password = $password;
        $user->national_code = $national_code;
        $user->gender = $gender;
        $user->birthday = $birthday;


        if ($user->save()) {
            return $user;
        } else {
            return false;
        }
    }
}
