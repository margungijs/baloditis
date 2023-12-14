<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PdfController;

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

Route::post('/productAdd', [ProductController::class, 'store']);

Route::get('/getProducts', [ProductController::class, 'getProducts']);

Route::put('/getProducts/{id}', [ProductController::class, 'update']);

Route::post('/login', [AuthController::class, 'login']); 

Route::get('/groupedProducts', [ProductController::class, 'groupedProducts']);

Route::put('/updateCategory/{productID}', [ProductController::class, 'setCategory']);

Route::get('/PDFAtskaite', [PdfController::class, 'generatePDF']);

Route::delete('/products/{id}', [ProductController::class, 'destroy']);


