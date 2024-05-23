<?php

use App\Models\Order;
use App\Models\User;
use Core\Services\Database;
use GuzzleHttp\Client;

Database::init();

const BASE_URL = 'http://localhost:8000';

test('should be list orders', function () {
    $user = User::create([
        'first_name' => 'John',
        'last_name' => 'Doe',
        'document' => '12345678900',
        'email' => 'mario@test.com',
        'phone_number' => '12345678900',
        'birth_date' => '1990-01-01'
    ]);

    $orders = Order::create([
        'user_id' => $user->id,
        'description' => 'Order test',
        'quantity' => 2,
        'price' => 100.00,
    ]);

    $client = new Client();

    $client->post(BASE_URL . '/auth/authenticate', [
            'form_params' => [
                'email' => $user->email,
                'birth_date' => $user->birth_date
            ]
        ]);

    $response = $client->get(BASE_URL . '/orders');

    expect($response->getStatusCode())
        ->toBe(200);
    expect((string) $response->getBody())
        ->toContain('Listagem de Pedidos');

    $orders->delete();
    $user->delete();
});
