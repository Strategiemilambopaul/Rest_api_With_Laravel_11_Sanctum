<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoursController;
use App\Http\Controllers\UsersController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CoursController::class)
    ->middleware('auth:sanctum')
    ->group(function(){

    Route::get('/cours','index');
    
    Route::get('/cours/{cours}','show');
    Route::post('/cours/store','store');
    Route::put('/cours/update','update');
    Route::delete('/cours/delete','destroy');
    Route::get('/cours/search/{search}','search');
});

Route::post('user/signup', [UsersController::class, 'signup']);
Route::post('user/login', [UsersController::class, 'login']);
