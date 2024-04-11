<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\DataAdminController;
use App\Http\Controllers\API\DataUserController;
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

Route::post('/login/user', [AuthController::class, 'loginUser']);
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);

// Route::middleware('auth:sanctum')->group(function () {
//     Route::group(['prefix' => 'api'], function () {
        Route::get('/employees', [DataUserController::class, 'index']);
        Route::post('/employees', [DataUserController::class, 'store']);
        Route::get('/employees/{id}', [DataUserController::class, 'show']);
        Route::put('/employees/{id}', [DataUserController::class, 'update']);
        Route::delete('/employees/{id}', [DataUserController::class, 'destroy']);
//     });
// });

Route::get('/admin', [DataAdminController::class, 'index']);
Route::post('/admin/register', [DataAdminController::class, 'store']);
Route::get('/admin/{id}', [DataAdminController::class, 'show']);
Route::delete('/admin/{id}', [DataAdminController::class, 'destroy']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout/user', [AuthController::class, 'logoutUser']);
    Route::post('/logout/admin', [AuthController::class, 'logoutAdmin']);
});

// Route::apiResource('data_admins', DataAdminController::class);
// Route::apiResource('employees', DataUserController::class);

