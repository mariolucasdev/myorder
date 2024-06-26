<?php

use App\Controllers\{AuthController, OrderController, UserController};
use Core\Libraries\{Route, View};

Route::get('/', function () {
    View::render('home', ['title' => 'Home']);
});

Route::get('/auth/login', function () {
    View::render('auth/login', ['title' => 'Login']);
});
Route::get('/auth/register', function () {
    View::render('auth/register', [
        'title' => 'Fazer Registro',
    ]);
});
Route::get('/auth/logout', [AuthController::class, 'logout']);
Route::post('/auth/authenticate', [AuthController::class, 'login']);
Route::post('/auth/signup', [AuthController::class, 'signup']);

Route::get('/users', [UserController::class, 'index'], requireAuth: true);
Route::get('/user/create', [UserController::class, 'create'], requireAuth: true);
Route::post('/user/store', [UserController::class, 'store'], requireAuth: true);
Route::get('/user/{id}/show', [UserController::class, 'show'], requireAuth: true);
Route::get('/user/{id}/edit', [UserController::class, 'edit'], requireAuth: true);
Route::put('/user/{id}/update', [UserController::class, 'update'], requireAuth: true);
Route::delete('/user/{id}/delete', [UserController::class, 'delete'], requireAuth: true);

Route::get('/orders', [OrderController::class, 'index'], requireAuth: true);
Route::get('/order/create', [OrderController::class, 'create'], requireAuth: true);
Route::post('/order/store', [OrderController::class, 'store'], requireAuth: true);
Route::get('/order/{id}/edit', [OrderController::class, 'edit'], requireAuth: true);
Route::put('/order/{id}/update', [OrderController::class, 'update'], requireAuth: true);
Route::delete('/order/{id}/delete', [OrderController::class, 'delete'], requireAuth: true);
