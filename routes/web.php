<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProjectController;

Route::get('/', function () {
    return view('welcome');
});
Route::resource('tasks', TaskController::class);
Route::resource('projects', ProjectController::class);