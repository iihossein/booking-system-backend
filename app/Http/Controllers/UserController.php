<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\WhoamiResource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HttpResponses;
    public function whoami()
    {
        $user = auth()->user();
        return new UserResource($user);
    }
}
