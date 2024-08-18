<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\ReviewController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\ExpertiseController;



// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Expertises
Route::prefix('expertises')->group(function () {
    Route::get('/', [ExpertiseController::class, 'index'])->name('expertise.index');
    Route::get('/{id}', [ExpertiseController::class, 'show'])->name('expertise.show');
    Route::get('/search/{id}', [ExpertiseController::class, 'search']);
});
Route::post('expertises/', [ExpertiseController::class, 'store'])->middleware('auth:sanctum');
Route::put('expertises/{id}', [ExpertiseController::class, 'update'])->middleware('auth:sanctum');
Route::delete('expertises/{id}', [ExpertiseController::class, 'destroy'])->middleware('auth:sanctum');


Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/{id}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::delete('/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
});


// doctorSchedules
Route::prefix('doctorSchedules')->group(function () {
    Route::get('/', [DoctorScheduleController::class, 'index'])->name('expertise.index');
    Route::get('/{doctor_id}', [DoctorScheduleController::class, 'show'])->name('expertise.show');
});
Route::post('doctorSchedules/', [DoctorScheduleController::class, 'store'])->middleware('auth:sanctum');
Route::put('doctorSchedules/{doctor_id}', [DoctorScheduleController::class, 'update'])->middleware('auth:sanctum');
Route::delete('doctorSchedules/{doctor_id}', [DoctorScheduleController::class, 'destroy'])->middleware('auth:sanctum');



// Appointments
Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index'])->name('expertise.index');
    Route::get('/{id}', [AppointmentController::class, 'show'])->name('expertise.show');
});



Route::prefix('reviews')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::post('/', [ReviewController::class, 'store']);
        Route::put('/{id}', [ReviewController::class, 'update']);
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
    });
    Route::get('/', [ReviewController::class, 'index'])->name('review.index');
    Route::get('/{id}', [ReviewController::class, 'show'])->name('review.show');
});


// Pages
// Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/search/{name}', [PageController::class, 'search']);


// Auth
Route::post('auth/sendCode', [AuthController::class, 'sendCode']);
Route::post('auth/checkCode', [AuthController::class, 'checkCode']);
Route::post('auth/checkPassword', [AuthController::class, 'checkPassword']);
Route::post('auth/registerUser', [AuthController::class, 'registerUser']);
Route::post('auth/changePassword', [AuthController::class, 'changePassword']);
Route::post('auth/resetPassword', [AuthController::class, 'resetPassword']);







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

Route::get("/", [HomeController::class, 'index']);

