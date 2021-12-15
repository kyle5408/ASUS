<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Firebase\ContactController;


Route::get('contacts', [ContactController::class, 'index']);
Route::get('add-contact', [ContactController::class, 'create']);
Route::post('add-contact', [ContactController::class, 'store']);
Route::get('register', [ContactController::class, 'register']);
Route::post('register', [ContactController::class, 'storeMember']);

Route::get('/', function () {
    return view('welcome');
});
