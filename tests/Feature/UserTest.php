<?php

use GuzzleHttp\Client;

test('can see user list', function () {
    $client = new Client();

    $response = $client->get('http://localhost:8000/users');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Usuários Cadastrados');
});

test('can see user create form', function () {
    $client = new Client();

    $response = $client->get('http://localhost:8000/user/create');

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
