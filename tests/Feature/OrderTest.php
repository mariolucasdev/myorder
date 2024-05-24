<?php

use App\Models\{Order, User};
use Core\Services\Database;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Cookie\CookieJar;

use function Pest\Faker\fake;

Database::init();

test('should be list orders', function () {
    $user = User::create([
        'first_name'   => 'John',
        'last_name'    => 'Doe',
        'document'     => '12345678900',
        'email'        => 'mario@test.com',
        'phone_number' => '12345678900',
        'birth_date'   => '1990-01-01',
    ]);

    $orders = Order::create([
        'user_id'     => $user->id,
        'description' => 'Order test',
        'quantity'    => 2,
        'price'       => 100.00,
    ]);

    $http      = new Http();
    $cookieJar = new CookieJar();

    $response = $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->get(BASE_URL . '/orders', [
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Listagem de Pedidos');

    $orders->delete();
    $user->delete();
})->group('order');

test('can be showed form to create order', function () {
    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('12345678900'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date'   => fake()->date(),
    ]);

    $http      = new Http();
    $cookieJar = new CookieJar();

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->get(BASE_URL . '/order/create', [
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Valor Total')
        ->toContain('Criar Pedido');

    $user->delete();
})->group('order');

test('can be store order', function () {
    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('12345678900'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date'   => fake()->date(),
    ]);

    $http      = new Http();
    $cookieJar = new CookieJar();

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->post(BASE_URL . '/order/store', [
        'form_params' => [
            'user_id'     => $user->id,
            'description' => 'Order test',
            'quantity'    => 2,
            'price'       => 100.00,
            '_token'      => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Listagem de Pedidos');

    $user->delete();
})->group('order');

test('assert price order', function () {
    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('12345678900'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date'   => fake()->date(),
    ]);

    $http      = new Http();
    $cookieJar = new CookieJar();

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $http->post(BASE_URL . '/order/store', [
        'form_params' => [
            'user_id'     => $user->id,
            'description' => 'Order test',
            'quantity'    => 2,
            'price'       => 'R$ 100,00',
            '_token'      => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $order = Order::where('user_id', $user->id)->first();

    expect($order->price)
        ->toBe('100.00')
        ->and($order->total)
        ->toBe(200.00);

    $user->delete();
})->group('order');

test('should be showed edit form to update order', function () {
    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('12345678900'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date'   => fake()->date(),
    ]);

    $order = Order::create([
        'user_id'     => $user->id,
        'description' => 'Order test',
        'quantity'    => 2,
        'price'       => 100.00,
    ]);

    $http      = new Http();
    $cookieJar = new CookieJar();

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->get(BASE_URL . "/order/{$order->id}/edit", [
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Valor Total')
        ->toContain('Editar Pedido');

    $order->delete();
    $user->delete();
})->group('order');

test('should be update order', function () {
    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('12345678900'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date'   => fake()->date(),
    ]);

    $order = Order::create([
        'user_id'     => $user->id,
        'description' => 'Order test',
        'quantity'    => 2,
        'price'       => 100.00,
    ]);

    $http      = new Http();
    $cookieJar = new CookieJar();

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $orderData = [
        'user_id'     => $user->id,
        'description' => 'Order test updated',
        'quantity'    => 3,
        'price'       => '150.00',
        '_token'      => $_ENV['APP_TOKEN'] ?? '123',
    ];

    $response = $http->post(BASE_URL . "/order/{$order->id}/update", [
        'form_params' => $orderData,
        'cookies'     => $cookieJar,
    ]);

    $order = Order::find($order->id);

    expect($order->description)
        ->toBe($orderData['description'])
        ->and($order->quantity)
        ->toBe($orderData['quantity'])
        ->and($order->price)
        ->toBe('150.00')
        ->and($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Listagem de Pedidos');

    $order->delete();
    $user->delete();
})->group('order');

test('order should be deleted', function () {
    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('12345678900'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('12345678900'),
        'birth_date'   => fake()->date(),
    ]);

    $order = Order::create([
        'user_id'     => $user->id,
        'description' => 'Order test',
        'quantity'    => 2,
        'price'       => 100.00,
    ]);

    $http      = new Http();
    $cookieJar = new CookieJar();

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->post(BASE_URL . "/order/{$order->id}/delete", [
        'form_params' => [
            '_token' => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Listagem de Pedidos');

    $user->delete();
})->group('order');
