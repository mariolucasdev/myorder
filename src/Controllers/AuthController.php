<?php

namespace App\Controllers;

use Illuminate\Database\Eloquent\Model;
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
     * @param array<string> $request
     * @method static Model where(string $string, string $email)
     */
    public function login(array $request): void
    {
        /* @phpstan-ignore-next-line */
        $user = User::where('email', $request['email'])->first();

        if (!$user || $request['birth_date'] != $user->birth_date) {
            Session::flash('error', 'Credenciais inválidas');
            $this->redirect('/auth/login');
        }

        Session::set('user', $user);
        Session::set('auth', true);

        $this->redirect('/users');
    }

    /**
     * register user
     *
     * @param array<string> $request
     */
    public function signup(array $request): void
    {
        $validated = UserRequest::store($request);

        /* @phpstan-ignore-next-line */
        $user = User::create($validated);

        Session::set('user', $user);
        Session::set('auth', true);

        $this->redirect('/users');
    }

    /**
     * logout user
     */
    public function logout(): void
    {
        Session::destroy();

        $this->redirect('/auth/login');
    }
}
