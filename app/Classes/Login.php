<?php

namespace App\Classes;

use App\Models\User;

class Login
{
    public function makeToken($phone)
    {
        $user = User::where('phone', $phone)->first();
        $token = $user->createToken('remember_token');
        return $token->plainTextToken;
    }
}
