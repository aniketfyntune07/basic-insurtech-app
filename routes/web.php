<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\PolicyController;


Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::resource('policies', PolicyController::class);