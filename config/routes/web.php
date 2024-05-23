<?php

use App\Controllers\UserController;
use Core\Libraries\Route;
use Core\Libraries\View;

Route::get('/', function () {
    return View::render('home');
});

Route::get('/users', [UserController::class, 'index'], requireAuth: true);
Route::get('/user/create', [UserController::class, 'create'], requireAuth: true);
Route::post('/user/store', [UserController::class, 'store'], requireAuth: true);
Route::get('/user/{id}/edit', [UserController::class, 'edit'], requireAuth: true);
Route::put('/user/{id}/update', [UserController::class, 'update'], requireAuth: true);

// Route::get('/auth/login', [UserController::class, 'login']);
// Route::get('/auth/register', [UserController::class, 'register']);
// Route::post('/auth/register', [UserController::class, 'userRegister']);
