<?php

namespace App\Interfaces\Auth;

interface AuthControllerInterface
{
    /**
     * @param array<string> $request
     */
    public function login(array $request): void;

    public function logout(): void;

    /**
     * @param array<string> $request
     */
    public function signup(array $request): void;
}
