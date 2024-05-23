<?php

use App\Controllers\UserController;
use Core\Libraries\Route;
use Core\Libraries\View;

// Route::get('/', function () {
//     return View::render('home');
// });

Route::get('/users', [UserController::class, 'index']);
Route::get('/user/create', [UserController::class, 'create']);
Route::post('/user/store', [UserController::class, 'store']);

// Route::get('/user/{id}', [UserController::class, 'show']);
// Route::put('/user/{id}', [UserController::class, 'update']);
// Route::delete('/user/{id}', [UserController::class, 'destroy']);
