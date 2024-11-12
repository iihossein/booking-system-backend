<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Http\Resources\WhoamiResource;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use HttpResponses;
    function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }
    function show($id)
    {
        $user = User::where('id', $id);
        if (!$user) {
            return $this->errorResponse('not found', 'چنین کاربری وجود در سیستم وجود ندارد.', 404);
        }
        return new UserResource($user);
    }
    public function whoami()
    {
        $user = auth()->user();
        return new UserResource($user);
    }
}
