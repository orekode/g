<?php

use App\Http\Controllers\Authentication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'controller' => Authentication::class,
], function () {
    Route::post('/signup', 'signup');
    Route::post('/login', 'login');
});
