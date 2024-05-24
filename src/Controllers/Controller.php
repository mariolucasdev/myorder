<?php

namespace App\Controllers;

use App\Traits\ApiResponseJson;
use Core\Libraries\View;

class Controller
{
    use ApiResponseJson;

    /**
     * Controller constructor
     */
    public function __construct()
    {
        //
    }

    /**
     * render view file
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
