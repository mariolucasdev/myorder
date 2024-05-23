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

test('should display register form', function () {
    $client = new Client();

    $response = $client->get(BASE_URL . '/auth/register');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Fazer Registro');
});
