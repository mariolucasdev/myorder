<?php

namespace App\Interfaces\User;

interface UserControllerInterface
{
    public function __construct();

    public function index(): void;
}
