<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExpertiseController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SmsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('expertise')->group(function () {
    Route::get('/', [ExpertiseController::class, 'index'])->name('expertise.index');
    Route::get('/show/{id}', [ExpertiseController::class, 'show'])->name('expertise.show');
});
Route::prefix('doctor')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/show/{id}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::delete('/destroy/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
});


// Pages
Route::get('/', [PageController::class, 'home'])->name('home');



// Auth
Route::post('auth/sendCode', [AuthController::class, 'sendCode']);
Route::post('auth/checkCode', [AuthController::class, 'checkCode']);
Route::post('auth/checkPassword', [AuthController::class, 'checkPassword']);
Route::post('auth/registerUser', [AuthController::class, 'registerUser']);
Route::post('auth/changePassword', [AuthController::class, 'changePassword']);
Route::post('auth/resetPassword', [AuthController::class, 'resetPassword']);
Route::post('auth/logout', [AuthController::class, 'logout']);




// Protected routes
// Route::group(['middleware' => ['auth:sanctum']], function () {
//     Route::post('/logout', [AuthController::class, 'logout']);
//     Route::resource('/tasks', TasksController::class);
// });