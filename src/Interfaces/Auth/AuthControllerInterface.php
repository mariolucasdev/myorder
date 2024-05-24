<?php

namespace App\Interfaces\Auth;

interface AuthControllerInterface
{
    public function login(array $request): void;

    public function logout(): void;

    public function signup(array $request): void;
}
