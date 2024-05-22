<?php

use GuzzleHttp\Client;

use function Pest\Faker\fake;

test('can see user list', function () {
    $client = new Client();

    $response = $client->get('http://localhost:8000/users');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Usuários Cadastrados');
});
