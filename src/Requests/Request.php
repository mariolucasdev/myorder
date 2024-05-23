<?php

namespace App\Requests;

use DateTime;

class Request
{
    /**
    * sanitize input data
    *
    * @param string $data
    * @return string
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
     * @param string $email
     * @return boolean
     */
    public static function validateEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    /**
     * validate date
     *
     * @param string $date
     * @param string $format
     * @return boolean
     */
    public static function validateDate($date, $format = 'Y-m-d'): bool
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }

    /**
     * validate currency
     *
     * @param string $currency
     * @return string
     */
    public static function validateCurrency(string $currency): string
    {
        return preg_match('/^[0-9]+(?:\.[0-9]{1,2})?$/', $currency);
    }
}
