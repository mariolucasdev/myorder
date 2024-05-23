<?php

namespace Core\Libraries;

final class Route
{
    /**
     * get application route
     *
     * @param string $route
     * @param callable|array $callback
     * @return void
     */
    public static function get(string $route, callable|array $callback)
    {
        $requestUri = $_SERVER['REQUEST_URI'];

        $params = explode('/', $requestUri);

        if(count($params) >= 3 && is_int($params[2])) {
            $route = '/user/' . $params[2];
        }

        if ($requestUri === $route) {
            $requestMethod = $_SERVER['REQUEST_METHOD'];

            if($requestMethod !== 'GET') {

                exit;
            }

            if(is_callable($callback)) {
                return $callback();

                exit;
            }

            if(is_array($callback)) {
                if(isset($callback[0])) {
                    $controller = $callback[0];
                } else {
                    $controller = CONTROLLER_DEFAULT;
                }

                if(isset($callback[1])) {
                    $method = $callback[1];
                } else {
                    $method = 'index';
                }

                if(!class_exists($controller)) {
                    throw new \Exception("Controller {$controller} class does not exist");
                }

                $controller = new $controller();

                if(method_exists($controller, $method)) {
                    return $controller->{$method}();

                    exit;
                }

                throw new \Exception("Method {$method} does not exist in controller {$controller}");
            }

            header("HTTP/1.0 404 Internal Server Error");
        }
    }

    /**
     * post application route
     *
     * @param string $route
     * @param callable|array $callback
     * @return void
     */
    public static function post(string $route, callable|array $callback)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = $_SERVER['REQUEST_URI'];

        if ($requestUri === $route) {

            if($requestMethod !== 'POST') {
                header("HTTP/1.0 405 Method Not Allowed");

                exit;
            }

            if(is_callable($callback)) {
                return $callback();

                exit;
            }

            if(is_array($callback)) {
                $controller = $callback[0];
                $method = $callback[1];

                if(! class_exists($controller)) {
                    throw new \Exception("Controller {$controller} class does not exist");
                }

                $controller = new $controller();

                if(method_exists($controller, $method)) {
                    return $controller->{$method}($_POST);

                    exit;
                }

                throw new \Exception("Method {$method} does not exist in controller {$controller}");
            }
        }
    }
}
