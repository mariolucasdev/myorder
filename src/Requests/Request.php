<?php

namespace App\Requests;

use DateTime;

class Request
{
    /**
     * sanitize input data
     */
    public static function sanitizeInput(string $data): string
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

        return $data;
    }

    /**
     * validate email
     *
     * @param  string  $email
     */
    public static function validateEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * validate date
     *
     * @param  string  $date
     * @param  string  $format
     */
    public static function validateDate($date, $format = 'Y-m-d'): bool
    {
        $d = DateTime::createFromFormat($format, $date);

        return $d && $d->format($format) === $date;
    }

    /**
     * validate currency
     */
    public static function validateCurrency(string $currency): int|false
    {
        return preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/', $currency);
    }
}
