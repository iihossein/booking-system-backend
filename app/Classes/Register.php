<?php

namespace app\Classes;

use App\Models\User;

class Register
{
    public function registerNewUser(
        $password,
        $first_name,
        $last_name,
        $phone,
    ) {
        $user = new User();
        $user->phone = $phone;
        $user->password = $password;
        $user->first_name = $first_name;
        $user->last_name = $last_name;


        if ($user->save()) {
            return $user;
        } else {
            return false;
        }
    }
}
