<?php

namespace App\Controllers;

use App\Interfaces\Order\OrderControllerInterface;
use App\Models\Order;
use App\Requests\Order\OrderRequest;
use Core\Libraries\Session;

class OrderController extends Controller implements OrderControllerInterface
{
    /**
     * OrderController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * display list of orders
     */
    public function index(): void
    {
        $title  = 'Listagem de Pedidos';

        $orders = Order::all();

        $this->view('orders/index', compact('orders', 'title'));
    }

    /**
     * display form to create order
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
     * @param array<string> $request
     */
    public function store(array $request): void
    {
        $validated = OrderRequest::store($request);

        /* @phpstan-ignore-next-line */
        Order::create($validated);

        Session::flash('success', 'Pedido criado com sucesso!');

        $this->redirect('/orders');
    }

    /**
     * display form to edit order
     */
    public function edit(int $id): void
    {
        $title = 'Editar Pedido';

        /* @phpstan-ignore-next-line */
        $order = Order::find($id);

        if (!$order) {
            Session::flash('error', 'Pedido não encontrado!');

            $this->redirect('/orders');
        }

        $this->view('orders/edit', compact('order', 'title'));
    }

    /**
     * update order
     *
     * @param array<string> $request
     */
    public function update(array $request, int $id): void
    {
        $validated = OrderRequest::update($request);

        /* @phpstan-ignore-next-line */
        $order = Order::find($id);

        if (!$order) {
            Session::flash('error', 'Pedido não encontrado!');

            $this->redirect('/orders');
        }

        $order->update($validated);

        Session::flash('success', 'Pedido atualizado com sucesso!');

        $this->redirect('/orders');
    }

    /**
     * delete order
     */
    public function delete(int $id): void
    {
        /* @phpstan-ignore-next-line */
        $order = Order::find($id);

        if (!$order) {
            Session::flash('error', 'Pedido não encontrado!');

            $this->redirect('/orders');
        }

        $order->delete();

        Session::flash('success', 'Pedido deletado com sucesso!');

        $this->redirect('/orders');
    }
}
