<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Interfaces\User\UserControllerInterface;
use App\Models\User;

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
}
