<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Interfaces\User\UserControllerInterface;
use App\Models\User;
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
            compact('users', 'title')
        );
    }

    public function create(): void
    {
        $title = 'Cadastrar Usuário';

        $this->view('users/create', compact('title'));
    }

    public function store($request): void
    {
        $data = [
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'document' => $request['document'],
            'email' => $request['email'],
            'phone_number' => $request['phone_number'],
            'birth_date' => $request['birth_date'],
        ];

        User::create($data);

        Session::flash('success', 'Usuário cadastrado com sucesso!');

        $this->redirect('/users');
    }
}
