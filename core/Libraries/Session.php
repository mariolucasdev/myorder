<?php

namespace Core\Libraries;

final class Session
{
    /**
     * start session
     */
    public static function init(): void
    {
        session_start();
    }

    /**
     * set session key and value
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get session value by key
     */
    public static function get(string $key): mixed
    {
        return $_SESSION[$key];
    }

    /**
     * check if session key exists
     */
    public static function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * set flashdata
     *
     * @return mixed
     */
    public static function flash(string $key, mixed $value = null)
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
     * @param  string  $key
     */
    public static function remove($key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * destroy session
     */
    public static function destroy(): void
    {
        session_destroy();
    }
}
