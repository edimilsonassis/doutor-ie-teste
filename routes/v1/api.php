<?php

use Illuminate\Http\Request;
use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\BookController;
use App\Http\Controllers\v1\UserController;
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

// HOME
Route::get('/', function () {
    return response()->json([]);
    // return view('welcome
});

// AUTH
Route::group([

    'middleware' => 'api',
    'prefix'     => 'auth'

], function ($router) {

    Route::post('token', [AuthController::class, 'token']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);

});


// BOOKS
Route::group([

    'middleware' => 'api',
    'prefix'     => 'livros',

], function ($router) {

    Route::get('/', [BookController::class, 'index']);
    Route::post('/', [BookController::class, 'store']);

});

// USERS
Route::middleware('api')->apiResource('usuarios', UserController::class);