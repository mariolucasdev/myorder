<?php

namespace Core\Libraries;

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
        $loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/../../resources/views');

        $twig = new \Twig\Environment($loader, [
            'cache' => __DIR__ . '/../../storage/cache',
        ]);

        echo $twig->render("{$view}.twig", $data);
    }
}
