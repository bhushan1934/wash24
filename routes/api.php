<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\AuthController;


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
Route::get('/get-user', [userController::class, 'getUser']);
Route::post('/register', [AuthController::class, 'registerAndGenerateOtp']);
Route::post('/generate-otp', [AuthController::class, 'generateOtp']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/user/profile', [userController::class, 'createUserProfile']);

Route::middleware('auth:api')->group(function () {
    Route::post('/user/profile', [userController::class, 'createUserProfile']);
    
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [userController::class, 'getuser']);
});