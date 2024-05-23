<?php

namespace Core\Libraries;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    /**
     * render view file
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public static function render(string $view, array $data = []): void
    {
        // set source views path
        $loader = new FilesystemLoader(__DIR__ . '/../../resources/views');

        // set twig environment
        $twig = new Environment($loader);

        /* ready base url */
        $twig->addGlobal('BASE_URL', BASE_URL);

        /* session auth data */
        $twig->addGlobal('auth', Session::get('auth'));

        /* session user data */
        $twig->addGlobal('id', Session::has('id') ? Session::get('id') : null);
        $twig->addGlobal('name', Session::has('name') ? Session::get('name') : null);

        /* render view */
        echo $twig->render("{$view}.twig", $data);
    }
}
