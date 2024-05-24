<?php

namespace Core\Libraries;

final class Route
{
    /**
     * get application route
     *
     * @param string $route
     * @param callable|array<string> $callback
     */
    public static function get(string $route, callable|array $callback, $requireAuth = false)
    {
        $requestUri = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);

        $param  = false;
        $params = explode('/', $requestUri);

        array_shift($params);

        if (strpos($route, '{id}') && isset($params[1])) {
            $param = (int) $params[1];
            $route = str_replace('{id}', $params[1], $route);
        }

        if ($requestUri === $route) {

            $requestMethod = $_SERVER['REQUEST_METHOD'];

            if ($requestMethod !== 'GET') {
                exit;
            }

            if (is_callable($callback)) {
                return $callback();

                exit;
            }

            if (is_array($callback)) {
                $controller = $callback[0];

                if (isset($callback[1])) {
                    $method = $callback[1];
                } else {
                    $method = 'index';
                }

                if (!class_exists($controller)) {
                    throw new \Exception("Controller {$controller} class does not exist");
                }

                Session::flash('requireAuth', $requireAuth);

                $controller = new $controller();

                if (method_exists($controller, $method)) {
                    if ($param) {
                        return $controller->{$method}($param);
                    }

                    return $controller->{$method}();

                    exit;
                }

                throw new \Exception("Method {$method} does not exist in controller {$controller}");
            }

            header('HTTP/1.0 404 Internal Server Error');
        }
    }

    /**
     * post application route
     *
     * @param string $route
     * @param callable|array<string> $callback
     */
    public static function post(string $route, callable|array $callback, $requireAuth = false)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri    = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);

        if ($requestUri === $route) {

            if ($requestMethod !== 'POST') {
                header("HTTP/1.0 405 Method Not Allowed");

                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $csrfToken = $_POST['_token'] ?? '';

                if (!hash_equals($_ENV['APP_TOKEN'], $csrfToken)) {
                    header('HTTP/1.0 403 Forbidden');

                    exit;
                }
            }

            if (is_callable($callback)) {
                return $callback();

                exit;
            }

            if (is_array($callback)) {
                $controller = $callback[0];
                $method     = $callback[1];

                if (!class_exists($controller)) {
                    throw new \Exception("Controller {$controller} class does not exist");
                }

                Session::flash('requireAuth', $requireAuth);

                $controller = new $controller();

                if (method_exists($controller, $method)) {
                    return $controller->{$method}($_POST);

                    exit;
                }

                throw new \Exception("Method {$method} does not exist in controller {$controller}");
            }
        }
    }

    /**
     * put application route
     *
     * @param string $route
     * @param callable|array<string> $callback
     */
    public static function put(string $route, callable|array $callback, $requireAuth = true)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri    = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);

        $param  = false;
        $params = explode('/', $requestUri);

        array_shift($params);

        if (strpos($route, '{id}') && isset($params[1])) {
            $param = (int) $params[1];
            $route = str_replace('{id}', $params[1], $route);
        }

        if ($requestUri === $route) {

            if ($requestMethod !== 'PUT' &&
                $requestMethod !== 'PATCH' &&
                $requestMethod !== 'POST'
            ) {
                header('HTTP/1.0 405 Method Not Allowed');

                exit;
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $csrfToken = $_POST['_token'] ?? '';

                    if (!hash_equals($_ENV['APP_TOKEN'], $csrfToken)) {
                        header('HTTP/1.0 403 Forbidden');

                        exit;
                    }
                }
            }

            if (is_callable($callback)) {
                return $callback();

                exit;
            }

            if (is_array($callback)) {
                $controller = $callback[0];
                $method     = $callback[1];

                if (!class_exists($controller)) {
                    throw new \Exception("Controller {$controller} class does not exist");
                }

                Session::flash('requireAuth', $requireAuth);

                $controller = new $controller();

                if (method_exists($controller, $method)) {
                    return $controller->{$method}($_POST, $param);

                    exit;
                }

                throw new \Exception("Method {$method} does not exist in controller {$controller}");
            }
        }
    }

    /**
     * delete application route
     *
     * @param string $route
     * @param callable|array<string> $callback
     */
    public static function delete(string $route, callable|array $callback, $requireAuth = true)
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri    = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL);

        $param  = false;
        $params = explode('/', $requestUri);

        array_shift($params);

        if (strpos($route, '{id}') && isset($params[1])) {
            $param = (int) $params[1];
            $route = str_replace('{id}', $params[1], $route);
        }

        if ($requestUri === $route) {

            if ($requestMethod !== 'POST' && $requestMethod !== 'DELETE') {
                header('HTTP/1.0 405 Method Not Allowed');

                exit;
            } else {
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $csrfToken = $_POST['_token'] ?? '';

                    if (!hash_equals($_ENV['APP_TOKEN'], $csrfToken)) {
                        header('HTTP/1.0 403 Forbidden');

                        exit;
                    }
                }
            }

            if (is_callable($callback)) {
                return $callback();

                exit;
            }

            if (is_array($callback)) {
                $controller = $callback[0];
                $method     = $callback[1];

                if (!class_exists($controller)) {
                    throw new \Exception("Controller {$controller} class does not exist");
                }

                Session::flash('requireAuth', $requireAuth);

                $controller = new $controller();

                if (method_exists($controller, $method)) {
                    return $controller->{$method}($param);

                    exit;
                }

                throw new \Exception("Method {$method} does not exist in controller {$controller}");
            }
        }
    }
}
