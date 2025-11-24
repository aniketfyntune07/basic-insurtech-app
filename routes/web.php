<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LandingController;
use App\Http\Controllers\PolicyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PostsController;


Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::resource('policies', PolicyController::class);
Route::resource('customers', CustomerController::class);
Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');

