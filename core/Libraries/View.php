<?php

namespace Core\Libraries;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class View
{
    /**
     * render view file
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
        $twig->addGlobal('user', Session::has('user') ? Session::get('user') : null);

        /* session fash */
        $twig->addGlobal('success', Session::has('success') ? Session::flash('success') : null);
        $twig->addGlobal('error', Session::has('error') ? Session::flash('error') : null);

        /* render view */
        echo $twig->render("{$view}.twig", $data);
    }
}
