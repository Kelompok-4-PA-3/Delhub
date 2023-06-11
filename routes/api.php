<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\KrsController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\RoomController;
use App\Http\Controllers\API\RequestController;
use App\Http\Controllers\API\AssesmentController;

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

Route::middleware('auth:sanctum')->get('/mahasiswa', [AuthController::class, 'getMahasiswa']);
Route::middleware('auth:sanctum')->get('/dosen', [AuthController::class, 'getDosen']);
Route::middleware('auth:sanctum')->get('/kelompok', [AuthController::class, 'getKelompok']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/store-token', [AuthController::class, 'storeToken'])->middleware('auth:sanctum');


Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'requests'
], function () {
    Route::get('/', [RequestController::class, 'index']);
    Route::post('/', [RequestController::class, 'store']);
    Route::get('/{id}', [RequestController::class, 'show']);
    Route::post('/{id}', [RequestController::class, 'update']);
});

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'rooms'
], function () {
    Route::get('/', [RoomController::class, 'index']);
});

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'krs'
], function () {
    Route::get('/', [KrsController::class, 'index']);
    Route::get('/{id}/kelompoks', [KrsController::class, 'getKelompoks']);
});

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'assesment'
], function () {
    Route::get('/{id}', [AssesmentController::class, 'getAssesmentPointByGroupId']);
});
