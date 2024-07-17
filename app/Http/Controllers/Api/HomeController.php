<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @OA\PathItem(path="/api")
     *
     * @OA\Info(
     *      version="0.0.0",
     *      title="Anophel API Documentation"
     *  )
     */
    public function index(): string
    {
        return "API";
    }

}
