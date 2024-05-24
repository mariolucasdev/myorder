<?php

namespace App\Controllers;

use Core\Libraries\{Session, View};

class Controller
{
    /**
     * Controller constructor
     */
    public function __construct()
    {
        if(Session::has('requireAuth') && Session::flash('requireAuth') === true && !Session::has('auth')) {
            $this->redirect('/auth/login');
        }
    }

    /**
     * render view file
     *
     * @param string $view
     * @param array<string> $data
     */
    public function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }

    /**
     * redirect to url
     */
    public function redirect(string $url): void
    {
        header("Location: {$url}", true, 302);

        exit;
    }
}
