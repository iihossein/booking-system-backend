<?php

use App\Http\Controllers\ExpertiseController;
use App\Models\Expertise;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    $ex = Expertise::find(1);
    return view('welcome',compact('ex'));
});


// dont use this page