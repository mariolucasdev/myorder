<?php

namespace App\Requests\Order;

use App\Requests\Request;
use Exception;

class OrderRequest extends Request
{
    /**
     * validate fields to action store order
     *
     * @param array<string> $request
     * @return array<string>
     */
    public static function store(array $request): array
    {
        $userId      = self::sanitizeInput($request['user_id'] ?? '');
        $description = self::sanitizeInput($request['description'] ?? '');
        $quantity    = self::sanitizeInput($request['quantity'] ?? '');

        $price = str_replace(['R$', ' ', ','], ['', '', '.'], $request['price']);
        $price = floatval($price);

        if (!$userId) {
            throw new Exception('User id is required');
        }

        if (!$description) {
            throw new Exception('Description is required');
        }

        if (!$quantity) {
            throw new Exception('Quantity is required');
        }

        if (!$price) {
            throw new Exception('Price is required');
        }

        return [
            'user_id'     => $userId,
            'description' => $description,
            'quantity'    => $quantity,
            'price'       => $price,
        ];
    }

    /**
     * validate fields to action update order
     *
     * @param array<string> $request
     * @return array<string>
     */
    public static function update(array $request): array
    {
        $description = self::sanitizeInput($request['description'] ?? '');
        $quantity    = self::sanitizeInput($request['quantity'] ?? '');

        $price = str_replace(['R$', ' ', ','], ['', '', '.'], $request['price']);
        $price = floatval($price);

        if (!$description) {
            throw new Exception('Description is required');
        }

        if (!$quantity) {
            throw new Exception('Quantity is required');
        }

        if (!$price) {
            throw new Exception('Price is required');
        }

        return [
            'description' => $description,
            'quantity'    => $quantity,
            'price'       => $price,
        ];
    }
}
