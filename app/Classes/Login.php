<?php

namespace app\Classes;

use App\Models\User;

class Login
{
    public function makeToken($phone)
    {
        $user = User::where('phone', $phone)->first();
        $token = $user->createToken($phone);
        return $token->plainTextToken;
    }
}
