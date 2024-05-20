<?php

use GuzzleHttp\Client;

test('should be showed home page', function () {
    $client = new Client();
    $response = $client->get('http://localhost:8000');

    expect(
        $response->getStatusCode()
    )->toBe(200);
});
