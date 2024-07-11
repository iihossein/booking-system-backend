<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ExpertiseController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Controller\ErrorController;


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



Route::post('auth/logout/{phone}', [AuthController::class, 'logout']);




// Protected routes
Route::group(['middleware' => ['auth:sanctum', 'sanctum.auth']], function () {
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('whoami', [UserController::class, 'whoami']);
});
Route::get('401', function () {
    return response()->json(
        [
            'status' => 'error',
            'description' => 'Unauthenticated',
            'message' => 'برای دسترسی به این بخش نیاز به لاگین است'
        ],
        401
    );
})->name('401');
