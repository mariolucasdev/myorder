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

// test('should be created a new user', function () {
//     $client = new Client();

//     $response = $client->post('http://localhost:8000/users', [
//         'form_params' => [
//             'name' => fake()->name,
//             'email' => fake()->email,
//             'password' => 'password'
//         ]
//     ]);

//     expect($response->getStatusCode())
//         ->toBe(302);

//     expect((string) $response->getBody())
//         ->toContain('Usuário criado com sucesso');
// });
