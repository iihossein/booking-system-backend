<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\ReviewController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\ExpertiseController;


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('expertises')->group(function () {
    Route::get('/', [ExpertiseController::class, 'index']);
    Route::get('/{id}', [ExpertiseController::class, 'show']);
    Route::get('/search/{id}', [ExpertiseController::class, 'search']);

    Route::middleware(['auth:sanctum', 'role:administrator'])->group(function () {
        Route::post('/', [ExpertiseController::class, 'store']);
        Route::put('/{id}', [ExpertiseController::class, 'update']);
        Route::delete('/{id}', [ExpertiseController::class, 'destroy']);
    });
});

Route::prefix('doctors')->group(function () {
    Route::get('/', [DoctorController::class, 'index'])->name('doctor.index');
    Route::get('/{id}', [DoctorController::class, 'show'])->name('doctor.show');
    Route::delete('/{id}', [DoctorController::class, 'destroy'])->name('doctor.destroy');
});


// DoctorSchedules
Route::prefix('doctorSchedules')->group(function () {
    Route::get('/', [DoctorScheduleController::class, 'index']);
    Route::get('/{doctor_id}', [DoctorScheduleController::class, 'show']);

    Route::middleware(['auth:sanctum', 'role:administrator|doctor'])->group(function () {
        Route::post('/', [DoctorScheduleController::class, 'store']);
        Route::put('/{doctor_id}', [DoctorScheduleController::class, 'update']);
        Route::delete('/{doctor_id}', [DoctorScheduleController::class, 'destroy']);
    });
});


// Appointments
Route::prefix('appointments')->group(function () {
    Route::get('/', [AppointmentController::class, 'index']);
    Route::get('/{id}', [AppointmentController::class, 'show']);
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/book', [AppointmentController::class, 'book'])->name('appointments.book');
        Route::post('/cancel', [AppointmentController::class, 'cancel'])->name('appointments.cancel');
    });
});



Route::prefix('reviews')->group(function () {
    Route::get('/', [ReviewController::class, 'index'])->name('review.index');
    Route::get('/{id}', [ReviewController::class, 'show'])->name('review.show');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [ReviewController::class, 'store']);
        Route::put('/{id}', [ReviewController::class, 'update']);
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
    });
});


// Pages
// Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/search/{name}', [PageController::class, 'search']);


// Auth
Route::prefix('auth')->group(function () {
    Route::post('sendCode', [AuthController::class, 'sendCode']);
    Route::post('checkCode', [AuthController::class, 'checkCode']);
    Route::post('checkPassword', [AuthController::class, 'checkPassword']);
    Route::post('registerUser', [AuthController::class, 'registerUser']);
    Route::post('changePassword', [AuthController::class, 'changePassword']);
    Route::post('resetPassword', [AuthController::class, 'resetPassword']);
});







// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
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




