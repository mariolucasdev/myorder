<?php

namespace App\Interfaces\User;

interface UserControllerInterface
{
    public function __construct();

    public function index(): void;
    public function create(): void;
    public function store(array $data): void;
    public function edit(int $id): void;
    public function update(array $data, int $id): void;
}
