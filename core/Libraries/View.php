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
        $loader = new FilesystemLoader(__DIR__ . '/../../resources/views');

        $twig = new Environment($loader, [
            // 'cache' => __DIR__ . '/../../storage/cache',
        ]);

        /* ready base url */
        $twig->addGlobal('BASE_URL', BASE_URL);

        /* session data */
        $twig->addGlobal('auth', isset($_SESSION['user']) ? $_SESSION['user'] : null);
        $twig->addGlobal('name', isset($_SESSION['name']) ? $_SESSION['name'] : null);
        $twig->addGlobal('id', isset($_SESSION['id']) ? $_SESSION['id'] : null);

        /* render view */
        echo $twig->render("{$view}.twig", $data);
    }
}
