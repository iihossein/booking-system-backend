<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\WhoamiResource;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function whoami()
    {
        $user = auth()->user();
        return new UserResource($user);
    }
}
