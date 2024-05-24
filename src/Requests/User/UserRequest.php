<?php

namespace App\Requests\User;

use App\Requests\Request;
use Exception;

class UserRequest extends Request
{
    /**
     * validate fields to action store user
     *
     * @param array $request
     * @return array
     */
    public static function store(array $request): array
    {
        $firstName = self::sanitizeInput($request['first_name'] ?? '');
        $lastName = self::sanitizeInput($request['last_name'] ?? '');
        $email = self::sanitizeInput($request['email'] ?? '');
        $birthDate = self::sanitizeInput($request['birth_date'] ?? '');

        $document = preg_replace('/[^0-9]/', '', $request['document']);
        $phoneNumber = preg_replace('/[^0-9]/', '', $request['phone_number']);

        if(! $firstName) {
            throw new Exception("First name is required");
        }

        if(! $lastName) {
            throw new Exception("Last name is required");
        }

        if(! $document) {
            throw new Exception("Document is required");
        }

        if (! self::validateEmail($email)) {
            throw new Exception("Invalid email format");
        }

        if(! $phoneNumber) {
            throw new Exception("Phone number is required");
        }

        if (! self::validateDate($birthDate)) {
            throw new Exception("Invalid date format. Expected format: Y-m-d");
        }

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'document' => $document,
            'email' => $email,
            'phone_number' => $phoneNumber,
            'birth_date' => $birthDate
        ];
    }

    /**
     * validate fields to action update user
     *
     * @param array $request
     * @return array
     */
    public static function update(array $request): array
    {
        $firstName = self::sanitizeInput($request['first_name'] ?? '');
        $lastName = self::sanitizeInput($request['last_name'] ?? '');
        $document = self::sanitizeInput($request['document'] ?? '');
        $email = self::sanitizeInput($request['email'] ?? '');
        $phoneNumber = self::sanitizeInput($request['phone_number'] ?? '');
        $birthDate = self::sanitizeInput($request['birth_date'] ?? '');

        if(! $firstName) {
            throw new Exception("First name is required");
        }

        if(! $lastName) {
            throw new Exception("Last name is required");
        }

        if(! $document) {
            throw new Exception("Document is required");
        }

        if (! self::validateEmail($email)) {
            throw new Exception("Invalid email format");
        }

        if(! $phoneNumber) {
            throw new Exception("Phone number is required");
        }

        if (! self::validateDate($birthDate)) {
            throw new Exception("Invalid date format. Expected format: Y-m-d");
        }

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'document' => $document,
            'email' => $email,
            'phone_number' => $phoneNumber,
            'birth_date' => $birthDate
        ];
    }
}
