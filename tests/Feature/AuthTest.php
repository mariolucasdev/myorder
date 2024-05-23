<?php

use App\Models\User;
use Core\Services\Database;
use GuzzleHttp\Client;

use function Pest\Faker\fake;

Database::init();

test('should display login form', function () {
    $client = new Client();

    $response = $client->get(BASE_URL . '/auth/login');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Login');
});

test('should login user', function () {
    $client = new Client();

    $response = $client->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email' => 'mariolucasdev@gmail.com',
            'birth_date' => '1994-06-22'
        ]
    ]);

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Usuários Cadastrados');
});

test('should display register form', function () {
    $client = new Client();

    $response = $client->get(BASE_URL . '/auth/register');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Fazer Registro');
});
