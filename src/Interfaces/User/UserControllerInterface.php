<?php

namespace App\Interfaces\User;

interface UserControllerInterface
{
    public function __construct();

    public function index(): void;

    public function show(int $id): void;

    public function create(): void;

    /**
     * @param array<string> $request
     * @return void
     */
    public function store(array $request): void;

    public function edit(int $id): void;

    /**
     * @param array<string> $request
     * @param int $id
     * @return void
     */
    public function update(array $request, int $id): void;
}
