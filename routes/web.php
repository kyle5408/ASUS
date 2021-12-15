<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Firebase\ContactController;





//login
Route::get('login', [ContactController::class, 'signin']);
Route::post('login', [ContactController::class, 'login']);

Route::get('contacts', [ContactController::class, 'index']);
Route::get('add-contact', [ContactController::class, 'create']);
Route::post('add-contact', [ContactController::class, 'store']);

Route::get('register', [ContactController::class, 'register']);
Route::post('register', [ContactController::class, 'storeMember']);

Route::post('logout', [ContactController::class, 'logout']);

Route::get('send', [ContactController::class, 'sendMsg']);
Route::post('send', [ContactController::class, 'send']);

Route::post('save-token', [ContactController::class, 'saveToken']);

Route::get('/', function () {
    return view('home');
});