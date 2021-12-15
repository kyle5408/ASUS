<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Firebase\ContactController;

Route::get('contacts', [ContactController::class, 'deviceList']);

Route::get('register', [ContactController::class, 'registerPage']);
Route::post('register', [ContactController::class, 'registerDevice']);

Route::get('send', [ContactController::class, 'sendMsg']);
Route::post('send', [ContactController::class, 'send']);

Route::get('/', function () {
    return view('home');
});