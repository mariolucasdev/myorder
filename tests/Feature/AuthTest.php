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
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Login');
});

test('should login user', function () {
    $http = new Http();

    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('0123456789'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date' => fake()->date('Y-m-d'),
    ]);

    $response = $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email' => $user->email,
            'birth_date' => $user->birth_date
        ]
    ]);

    expect($response->getStatusCode())
        ->toBe(200);

    expect((string) $response->getBody())
        ->toContain('Usuários Cadastrados');
});

test('should logout user', function () {
    $http = new Http();

    $response = $http->get(BASE_URL . '/auth/logout');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Login');
});

test('should display register form', function () {
    $http = new Http();

    $response = $http->get(BASE_URL . '/auth/register');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Fazer Registro');
});

test('should register user', function () {
    $http = new Http();

    $response = $http->post(BASE_URL . '/auth/signup', [
        'form_params' => [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'document' => fake()->shuffleString('0123456789'),
            'email' => fake()->email(),
            'phone_number' => fake()->shuffleString('01234567899'),
            'birth_date' => fake()->date('Y-m-d'),
        ]
    ]);

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Usuários Cadastrados');
});
