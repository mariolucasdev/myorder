<?php

namespace App\Interfaces\Order;

interface OrderControllerInterface
{
    public function index(): void;

    public function create(): void;

    /**
     * @param array<string> $request
     */
    public function store(array $request): void;

    public function edit(int $id): void;

    /**
     * @param array<string> $request
     * @param int $id
     */
    public function update(array $request, int $id): void;

    public function delete(int $id): void;
}
