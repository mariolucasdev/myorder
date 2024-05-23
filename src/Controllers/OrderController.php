<?php

namespace App\Controllers;

use App\Interfaces\Order\OrderControllerInterface;
use App\Models\Order;
use App\Requests\Order\OrderRequest;
use Core\Libraries\Session;

class OrderController extends Controller implements OrderControllerInterface
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * display list of orders
     *
     * @return void
     */
    public function index(): void
    {
        $title = 'Listagem de Pedidos';
        $orders = Order::all();

        $this->view('orders/index', compact('orders', 'title'));
    }

    /**
     * display form to create order
     *
     * @return void
     */
    public function create(): void
    {
        $title = 'Criar Pedido';

        $user = Session::get('user');


        $this->view('orders/create', compact('title'));
    }

    /**
     * store order
     *
     * @param array $request
     * @return void
     */
    public function store(array $request): void
    {
        $validated = OrderRequest::store($request);

        Order::create($validated);

        Session::flash('success', 'Pedido criado com sucesso!');

        $this->redirect('/orders');
    }

    /**
     * display form to edit order
     *
     * @param int $id
     * @return void
     */
    public function edit(int $id): void
    {
        $title = 'Editar Pedido';

        $order = Order::find($id);

        if(! $order) {
            Session::flash('error', 'Pedido não encontrado!');

            $this->redirect('/orders');
        }

        $this->view('orders/edit', compact('order', 'title'));
    }
}
