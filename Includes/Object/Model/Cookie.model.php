<?php

namespace Model;

/**
 * Cookie
 */
class Cookie 
{
    /**
     * Checks if cookie exists
     *
     * @param string $cookie Cookie name
     * 
     * @return bool
     */
    public static function exists( string $cookie )
    {
        return isset($_COOKIE[$cookie]);
    }

    /**
     * Returns value of cookie
     *
     * @param string $cookie
     * 
     * @return mixed
     */
    public static function get( string $cookie )
    {
        return $_COOKIE[$cookie] ?? '';
    }

    /**
     * Creates new cookie
     *
     * @param string $cookie Cookie name
     * @param mixed $value Cookie value
     * @param int $expiry
     * 
     * @return void
     */
    public static function put( string $cookie, $value, int $expiry = 0 )
    {
        setcookie($cookie, $value, time() + $expiry, '/', null, null, true);
    }

    /**
     * Deletes cookie
     *
     * @param string $cookie Cookie name
     * 
     * @return void
     */
    public static function delete( string $cookie )
    {
        self::put($cookie, '', -3600);
    }
}
