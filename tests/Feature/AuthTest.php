<?php

use App\Models\User;
use Core\Services\Database;
use GuzzleHttp\Client as Http;

use function Pest\Faker\fake;

Database::init();

test('should display login form', function () {
    $http = new Http();

    $response = $http->get(BASE_URL . '/auth/login');

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Login');
})->group('auth');

test('should login user', function () {
    $http = new Http();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('0123456789'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date'   => fake()->date('Y-m-d'),
    ]);

    $response = $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Seja bem vindo(a)');

    $user->delete();
})->group('auth');

test('should logout user', function () {
    $http = new Http();

    $response = $http->get(BASE_URL . '/auth/logout');

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Login');
})->group('auth');

test('should display register form', function () {
    $http = new Http();

    $response = $http->get(BASE_URL . '/auth/register');

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Fazer Registro');
})->group('auth');

test('should register user', function () {
    $http = new Http();

    $userData = [
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('0123456789'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date'   => fake()->date('Y-m-d'),
        '_token'       => $_ENV['APP_TOKEN'] ?? '123',
    ];

    $response = $http->post(BASE_URL . '/auth/signup', [
        'form_params' => $userData,
    ]);

    $user = User::where('document', $userData['document'])
        ->where('email', $userData['email'])
        ->first();

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Seja bem vindo(a)');

    User::destroy($user->id);
})->group('auth');
