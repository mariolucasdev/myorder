<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Interfaces\Auth\AuthControllerInterface;
use App\Models\User;
use App\Requests\User\UserRequest;
use Core\Libraries\Session;

class AuthController extends Controller implements AuthControllerInterface
{
    /**
     * UserController constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * do login user
     *
     * @return void
     */
    public function login(array $request): void
    {
        $user = User::where('email', $request['email'])->first();

        if (! $user || $request['birth_date'] != $user->birth_date) {
            Session::flash('error', 'Credenciais inválidas');
            $this->redirect('/auth/login');
        }

        Session::set('user', $user);
        Session::set('auth', true);

        $this->redirect('/users');
    }

    /**
     * logout user
     *
     * @return void
     */
    public function logout(): void
    {
        Session::destroy();

        $this->redirect('/auth/login');
    }
}
