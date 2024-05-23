<?php

namespace App\Controllers;

use App\Models\Order;
use Core\Libraries\View;

class OrderController
{
    public function index()
    {
        $title = 'Listagem de Pedidos';
        $orders = Order::all();

        return View::render('orders/index', compact('orders', 'title'));
    }
}
