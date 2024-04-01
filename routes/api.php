<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/store', [\App\Http\Controllers\Api\TasksController::class, 'store'])->name('store');
Route::get('/index', [\App\Http\Controllers\Api\TasksController::class, 'index'])->name('index');
Route::patch('/update/{task}', [\App\Http\Controllers\Api\TasksController::class, 'update'])->name('update');
Route::delete('/delete/{task}', [\App\Http\Controllers\Api\TasksController::class, 'destroy'])->name('destroy');

