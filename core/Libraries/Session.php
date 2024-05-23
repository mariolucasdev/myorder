<?php

namespace Core\Libraries;

final class Session
{
    /**
     * start session
     *
     * @return void
     */
    public static function init(): void
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
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get session value by key
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    /**
     * check if session key exists
     *
     * @param string $key
     * @return boolean
     */
    public static function has(string $key): bool
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
            self::set($key, $value);
        } else {
            $value = self::get($key);
            self::remove($key);

            return $value;
        }
    }

    /**
     * remove session key
     *
     * @param string $key
     * @return void
     */
    public static function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * destroy session
     *
     * @return void
     */
    public static function destroy(): void
    {
        session_destroy();
    }
}
