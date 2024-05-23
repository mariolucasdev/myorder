<?php

namespace App\Controllers;

use App\Controllers\Controller;
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
     *
     * @return void
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
     * create user form
     *
     * @return void
     */
    public function create(): void
    {
        $title = 'Cadastrar Usuário';

        $this->view('users/create', compact('title'));
    }

    /**
     * store user
     *
     * @param array $request
     * @return void
     */
    public function store(array $request): void
    {
        $validated = UserRequest::store($request);

        User::create($validated);

        Session::flash('success', 'Usuário cadastrado com sucesso!');

        $this->redirect('/users');
    }

    public function edit(int $id): void
    {
        $title = "Editar Usuário";

        $user = User::find($id);

        if(!$user) {
            Session::flash('error', 'Usuário não encontrado!');

            $this->redirect('/users');
        }

        $this->view('users/create', compact('title', 'user'));
    }
}
