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
     *
     * @param string $view
     * @param array $data
     * @return void
     */
    public function view(string $view, array $data = []): void
    {
        View::render($view, $data);
    }
}