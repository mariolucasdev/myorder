<?php

use App\Models\User;
use Core\Services\Database;
use GuzzleHttp\Client;

use function Pest\Faker\fake;

Database::init();

const BASE_URL = 'http://localhost:8000';

test('should display list of users', function () {
    $client = new Client();

    $response = $client->get(BASE_URL . '/users');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Usuários Cadastrados');
});

test('must display form for user editing', function () {
    $client = new Client([
        'base_uri' => BASE_URL
    ]);

    $response = $client->get('/user/create');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Cadastrar Usuário')
        ->toContain('name="first_name"')
        ->toContain('name="last_name"')
        ->toContain('name="document"')
        ->toContain('name="email"')
        ->toContain('name="phone_number"')
        ->toContain('name="birth_date"');
});

test('must create a new user', function () {
    $client = new Client();

    $user = [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('0123456789'),
        'email' => fake()->email(),
        'phone_number' => fake()->phoneNumber(),
        'birth_date' => fake()->date('Y-m-d'),
    ];

    $response = $client->post(BASE_URL . '/user/store', [
        'form_params' => $user
    ]);

    expect((string) $response->getBody())
        ->toContain($user['first_name'])
        ->toContain($user['last_name'])
        ->toContain($user['email']);
});

test('should display dorm for user editing', function () {
    $client = new Client();

    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('0123456789'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date' => fake()->date('Y-m-d'),
    ]);

    $response = $client->get(BASE_URL . "/user/{$user->id}/edit");

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain($user['name']);
});

test('user has been updated', function () {
    $client = new Client();

    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('0123456789'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date' => fake()->date('Y-m-d'),
    ]);

    $newUserData = [
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('0123456789'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date' => fake()->date('Y-m-d'),
    ];

    $response = $client->post(BASE_URL . "/user/{$user->id}/update", [
        'form_params' => $newUserData
    ]);

    expect($response->getStatusCode())
        ->toBe(200);

    expect((string) $response->getBody())
        ->toContain($newUserData['first_name'])
        ->toContain($newUserData['last_name'])
        ->toContain($newUserData['email']);
});

test('must delete user', function () {
    $client = new Client();

    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('0123456789'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date' => fake()->date('Y-m-d'),
    ]);

    $response = $client->delete(BASE_URL . "/user/{$user->id}/delete");

    expect($response->getStatusCode())
        ->toBe(200);
});
