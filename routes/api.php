<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\XrefController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::get('/xrefs', [XrefController::class, 'index']);
Route::get('/xrefs/{xref}', [XrefController::class, 'show']);
Route::get('/xrefs/search/{name}', [XrefController::class, 'search']);


// Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/xrefs', [XrefController::class, 'store']);
    Route::put('/xrefs/{xref}', [XrefController::class, 'update']);
    Route::delete('/xrefs/{xref}', [XrefController::class, 'destroy']);
    Route::post('/logout', [UserController::class, 'logout']);
});
