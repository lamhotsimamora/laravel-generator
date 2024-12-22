<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('home');
});

Route::post('/load-database', [AdminController::class, 'loadDatabase']);
Route::post('/load-table', [AdminController::class, 'loadTable']);
