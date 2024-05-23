<?php

use App\Controllers\UserController;
use App\Controllers\AuthController;
use Core\Libraries\Route;
use Core\Libraries\View;

Route::get('/', function () {
    return View::render('home');
});

Route::get('/auth/login', function () {
    return View::render('auth/login', [ 'title' => 'Login' ]);
});

Route::post('/auth/authenticate', [AuthController::class, 'login']);
Route::get('/auth/logout', [AuthController::class, 'logout']);

Route::get('/auth/register', function () {
    return View::render('auth/register', [
        'title' => 'Fazer Registro'
    ]);
});

Route::get('/users', [UserController::class, 'index'], requireAuth: true);
Route::get('/user/create', [UserController::class, 'create'], requireAuth: true);
Route::post('/user/store', [UserController::class, 'store'], requireAuth: true);
Route::get('/user/{id}/edit', [UserController::class, 'edit'], requireAuth: true);
Route::put('/user/{id}/update', [UserController::class, 'update'], requireAuth: true);
Route::delete('/user/{id}/delete', [UserController::class, 'delete'], requireAuth: true);

// Route::get('/auth/login', [UserController::class, 'login']);
// Route::get('/auth/register', [UserController::class, 'register']);
// Route::post('/auth/register', [UserController::class, 'userRegister']);
