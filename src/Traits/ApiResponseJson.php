<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Collection;

trait ApiResponseJson
{
    public function responseJson(array|Collection $data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);

        echo json_encode($data);

        exit;
    }
}
