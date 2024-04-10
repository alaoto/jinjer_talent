<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MasterAdminsController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// 全データの取得
Route::get('/masteradmins', [MasterAdminsController::class, 'readMasterAdmins']);
// 新規データの登録
Route::post('/masteradmins', [MasterAdminsController::class, 'createMasterAdmin']);
// 既存データの更新
Route::PUT('/masteradmins/{id}', [MasterAdminsController::class, 'updateMasterAdmin']);
// 既存データの論理削除
Route::delete('/masteradmins/{id}', [MasterAdminsController::class, 'deleteMasterAdmin']);
