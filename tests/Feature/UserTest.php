<?php

use App\Models\User;
use GuzzleHttp\Client as Http;
use GuzzleHttp\Cookie\CookieJar;

use function Pest\Faker\fake;

const BASE_URL = 'http://localhost:8000';

test('should display list of users', function () {
    $http      = new Http();
    $cookieJar = new CookieJar();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => '99999999999',
        'email'        => fake()->email(),
        'phone_number' => '99999999999',
        'birth_date'   => fake()->date('Y-m-d'),
        '_token'       => $_ENV['APP_TOKEN'] ?? '123',
    ]);

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->get(BASE_URL . '/users', [
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Usuários Cadastrados');

    $user->delete();
})->group('user');

test('must display show user and your orders', function () {
    $http      = new Http();
    $cookieJar = new CookieJar();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => '99999999999',
        'email'        => fake()->email(),
        'phone_number' => '99999999999',
        'birth_date'   => fake()->date('Y-m-d'),
    ]);

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $http->post(BASE_URL . '/user/store', [
        'form_params' => [
            'first_name'   => fake()->firstName(),
            'last_name'    => fake()->lastName(),
            'document'     => '987.879.987-55',
            'email'        => fake()->email(),
            'phone_number' => fake()->phoneNumber(),
            'birth_date'   => fake()->date('Y-m-d'),
            '_token'       => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $user = User::where('document', '98787998755')->first();

    $order = $user->orders()->create([
        'description' => fake()->sentence(),
        'price'       => fake()->randomFloat(2, 10, 100),
        'quantity'    => fake()->numberBetween(1, 10),
    ]);

    $response = $http->get(BASE_URL . "/user/{$user->id}/show", [
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Detalhes do Usuário')
        ->toContain($user->first_name)
        ->toContain($user->email)
        ->toContain($order->description)
        ->toContain($order->quantity);

    $user->delete();
    $user->orders()->delete();
})->group('user');

test('must display form for user create', function () {
    $http      = new Http();
    $cookieJar = new CookieJar();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('0123456789'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date'   => fake()->date('Y-m-d'),
    ]);

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->get(BASE_URL . '/user/create', [
        'cookies' => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain('Cadastrar Usuário')
        ->toContain('name="first_name"')
        ->toContain('name="last_name"')
        ->toContain('name="document"')
        ->toContain('name="email"')
        ->toContain('name="phone_number"')
        ->toContain('name="birth_date"');

    $user->delete();
})->group('user');

test('must create a new user', function () {
    $http      = new Http();
    $cookieJar = new CookieJar();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => '99999999999',
        'email'        => fake()->email(),
        'phone_number' => '99999999999',
        'birth_date'   => fake()->date('Y-m-d'),
    ]);

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $user = [
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('0123456789'),
        'email'        => fake()->email(),
        'phone_number' => fake()->phoneNumber(),
        'birth_date'   => fake()->date('Y-m-d'),
        '_token'       => $_ENV['APP_TOKEN'] ?? '123',
    ];

    $response = $http->post(BASE_URL . '/user/store', [
        'form_params' => $user,
        'cookies'     => $cookieJar,
    ]);

    expect((string) $response->getBody())
        ->toContain($user['first_name'])
        ->toContain($user['last_name'])
        ->toContain($user['email']);

    $user = User::where('document', $user['document'])->first();
    $user->delete();
})->group('user');

test('should display dorm for user editing', function () {
    $http = new Http();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('0123456789'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date'   => fake()->date('Y-m-d'),
    ]);

    $response = $http->get(BASE_URL . "/user/{$user->id}/edit");

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain($user['name']);

    $user->delete();
})->group('user');

test('user has been updated', function () {
    $http      = new Http();
    $cookieJar = new CookieJar();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => '99999999999',
        'email'        => fake()->email(),
        'phone_number' => '99999999999',
        'birth_date'   => fake()->date('Y-m-d'),
    ]);

    $newUserData = [
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('0123456789'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date'   => fake()->date('Y-m-d'),
        '_token'       => $_ENV['APP_TOKEN'] ?? '123',
    ];

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->post(BASE_URL . "/user/{$user->id}/update", [
        'form_params' => $newUserData,
        'cookies'     => $cookieJar,
    ]);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and((string) $response->getBody())
        ->toContain($newUserData['first_name'])
        ->toContain($newUserData['last_name'])
        ->toContain($newUserData['email']);

    $user->delete();
})->group('user');

test('must delete user', function () {
    $http      = new Http();
    $cookieJar = new CookieJar();

    $user = User::create([
        'first_name'   => fake()->firstName(),
        'last_name'    => fake()->lastName(),
        'document'     => fake()->shuffleString('0123456789'),
        'email'        => fake()->email(),
        'phone_number' => fake()->shuffleString('01234567899'),
        'birth_date'   => fake()->date('Y-m-d'),
        '_token'       => $_ENV['APP_TOKEN'] ?? '123',
    ]);

    $http->post(BASE_URL . '/auth/authenticate', [
        'form_params' => [
            'email'      => $user->email,
            'birth_date' => $user->birth_date,
            '_token'     => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $response = $http->delete(BASE_URL . "/user/{$user->id}/delete", [
        'form_params' => [
            '_token' => $_ENV['APP_TOKEN'] ?? '123',
        ],
        'cookies' => $cookieJar,
    ]);

    $user = User::find($user->id);

    expect($response->getStatusCode())
        ->toBe(200)
        ->and($user)
        ->toBeNull();
})->group('user');
