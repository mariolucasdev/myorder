<?php

use App\Models\User;
use GuzzleHttp\Client;

use function Pest\Faker\fake;

const BASE_URL = 'http://localhost:8000';

test('can see user list', function () {
    $client = new Client();

    $response = $client->get(BASE_URL . '/users');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Usuários Cadastrados');
});

test('can see user create form', function () {
    $client = new Client();

    $response = $client->get(BASE_URL . '/user/create');

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

test('should be created a new user', function () {
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
