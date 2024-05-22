<?php

namespace Core\Libraries;

final class Session
{
    public function __construct()
    {
        session_start();
    }

    /**
     * set session key and value
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get session value by key
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    /**
     * check if session key exists
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * set flashdata
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function flash(string $key, mixed $value = null): mixed
    {
        if ($value) {
            $this->set($key, $value);
        } else {
            $value = $this->get($key);
            $this->remove($key);

            return $value;
        }
    }

    /**
     * remove session key
     *
     * @param string $key
     * @return void
     */
    public function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * destroy session
     *
     * @return void
     */
    public function destroy(): void
    {
        session_destroy();
    }
}
