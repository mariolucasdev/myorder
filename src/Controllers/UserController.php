<?php

namespace App\Controllers;

use App\Interfaces\User\UserControllerInterface;
use App\Models\User;
use App\Requests\User\UserRequest;
use Core\Libraries\Session;

class UserController extends Controller implements UserControllerInterface
{
    /**
     * UserController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * List of users
     */
    public function index(): void
    {
        $title = 'Usuários Cadastrados';
        $users = User::all();

        $this->view(
            'users/index',
            compact('title', 'users')
        );
    }

    /**
     * show user
     */
    public function show(int $id): void
    {
        $title = 'Detalhes do Usuário';

        /* @phpstan-ignore-next-line */
        $user   = User::find($id);
        $orders = $user->orders;

        if (!$user) {
            Session::flash('error', 'Usuário não encontrado!');

            $this->redirect('/users');
        }

        $this->view('users/show', compact('title', 'user', 'orders'));
    }

    /**
     * create user form
     */
    public function create(): void
    {
        $title = 'Cadastrar Usuário';

        $this->view('users/create', compact('title'));
    }

    /**
     * store user
     *
     * @param array<string> $request
     */
    public function store(array $request): void
    {
        $validated = UserRequest::store($request);

        /* @phpstan-ignore-next-line */
        User::create($validated);

        Session::flash('success', 'Usuário cadastrado com sucesso!');

        $this->redirect('/users');
    }

    /**
     * edit user form
     */
    public function edit(int $id): void
    {
        $title = 'Editar Usuário';

        /* @phpstan-ignore-next-line */
        $user = User::find($id);

        if (!$user) {
            Session::flash('error', 'Usuário não encontrado!');

            $this->redirect('/users');
        }

        $this->view('users/edit', compact('title', 'user'));
    }

    /**
     * update user
     *
     * @param array<string> $request
     * @param int $id
     */
    public function update(array $request, int $id): void
    {
        /* @phpstan-ignore-next-line */
        $user = User::find($id);

        if (!$user) {
            Session::flash('error', 'Usuário não encontrado!');

            $this->redirect('/users');
        }

        $validated = UserRequest::update($request);

        $user->update($validated);

        Session::flash('success', 'Usuário atualizado com sucesso!');

        $this->redirect('/users');
    }

    /**
     * delete user
     */
    public function delete(int $id): void
    {
        /* @phpstan-ignore-next-line */
        $user = User::find($id);

        if (!$user) {
            Session::flash('error', 'Usuário não encontrado!');

            $this->redirect('/users');
        }

        $user->delete();

        Session::flash('success', 'Usuário deletado com sucesso!');

        $this->redirect('/users');
    }
}
