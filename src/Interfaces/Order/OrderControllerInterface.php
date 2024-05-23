<?php

namespace App\Interfaces\Order;

interface OrderControllerInterface
{
    public function index(): void;
    public function create(): void;
    public function store(array $request): void;
}
