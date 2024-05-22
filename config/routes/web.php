<?php

use App\Controllers\UserController;
use Core\Libraries\Route;
use Core\Libraries\View;

Route::get('/', function () {
    return View::render('home');
});

Route::get('/users', [UserController::class]);

// Route::get('/user/{id}', [UserController::class, 'show']);
// Route::post('/users', [UserController::class, 'store']);
// Route::put('/user/{id}', [UserController::class, 'update']);
// Route::delete('/user/{id}', [UserController::class, 'destroy']);
