<?php
namespace Ililuminates\Sessions;

class Session
{
    /**
     * @param string $key
     * @param mixed|null $value
     *
     * @return mixed
     */
    public static function make(string $key, mixed $value = null): mixed
    {
        if (! is_null($value)) {
            $_SESSION[$key] = encrypt($value);
        }
        return isset($_SESSION[$key]) ? decrypt($_SESSION[$key]) : '';
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public static function has(string $key): mixed
    {
        return isset($_SESSION[$key]);
    }

    /**
     * @param string $key
     * @param mixed|null $value
     *
     * @return mixed
     */
    public static function flash(string $key, mixed $value = null): mixed
    {
        if (! is_null($value)) {
            $_SESSION[$key] = $value;
        }
        $session = isset($_SESSION[$key]) ? decrypt($_SESSION[$key]) : '';
        self::forget($key);
        return $session;
    }

    /**
     * @param string $key
     *
     * @return void
     */
    public static function forget(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * @return void
     */
    public static function forget_all(): void
    {
        session_destroy();
    }
}
