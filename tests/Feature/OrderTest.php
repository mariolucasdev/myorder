<?php

use App\Models\Order;
use App\Models\User;
use Core\Services\Database;
use GuzzleHttp\Client;

use function Pest\Faker\fake;

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
})->group('order');

test('can be showed form to create order', function () {
    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('12345678900'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date' => fake()->date(),
    ]);

    $client = new Client();

    $client->post(BASE_URL . '/auth/authenticate', [
            'form_params' => [
                'email' => $user->email,
                'birth_date' => $user->birth_date
            ]
        ]);

    $response = $client->get(BASE_URL . '/order/create');

    expect($response->getStatusCode())
        ->toBe(200);

    expect((string) $response->getBody())
        ->toContain('Criar Pedido');

    $user->delete();
})->group('order');

test('can be store order', function () {
    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('12345678900'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date' => fake()->date(),
    ]);

    $client = new Client();

    $client->post(BASE_URL . '/auth/authenticate', [
            'form_params' => [
                'email' => $user->email,
                'birth_date' => $user->birth_date
            ]
        ]);

    $response = $client->post(BASE_URL . '/order/store', [
        'form_params' => [
            'user_id' => $user->id,
            'description' => 'Order test',
            'quantity' => 2,
            'price' => 100.00,
        ]
    ]);

    expect($response->getStatusCode())
        ->toBe(200);

    expect((string) $response->getBody())
        ->toContain('Listagem de Pedidos');

    $user->delete();
})->group('order');

test('assert price order', function () {
    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('12345678900'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date' => fake()->date(),
    ]);

    $client = new Client();

    $client->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email' => $user->email,
            'birth_date' => $user->birth_date
        ]
    ]);

    $client->post(BASE_URL . '/order/store', [
        'form_params' => [
            'user_id' => $user->id,
            'description' => 'Order test',
            'quantity' => 2,
            'price' => 'R$ 100,00',
        ]
    ]);

    $order = Order::where('user_id', $user->id)->first();

    expect($order->price)
        ->toBe('100.00');

    expect($order->total)
        ->toBe(200.00);

    $user->delete();
})->group('order');

test('should be showed edit form to update order', function () {
    $user = User::create([
        'first_name' => fake()->firstName(),
        'last_name' => fake()->lastName(),
        'document' => fake()->shuffleString('12345678900'),
        'email' => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date' => fake()->date(),
    ]);

    $order = Order::create([
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

    $response = $client->get(BASE_URL . "/order/{$order->id}/edit");

    expect($response->getStatusCode())
        ->toBe(200);

    expect((string) $response->getBody())
        ->toContain('Valor Total')
        ->toContain('Editar Pedido');

    $order->delete();
    $user->delete();
})->group('order');
