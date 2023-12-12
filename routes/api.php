<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::post('/UserAdd', [UserController::class, 'store']);

Route::get('/Users', [UserController::class, 'getUsers']);

Route::put('/UserUpdate/{userID}', [UserController::class, 'updateUser']);

Route::delete('/UserDelete/{userID}', [UserController::class, 'destroy']);
