<?php

namespace Model;

/**
 * Cookie
 */
class Cookie 
{
    /**
     * Checks ig given cookie exists.
     *
     * @param string $key
     * 
     * @return bool
     */
    public static function exists( string $key )
    {
        return isset($_COOKIE[$key]) ? true : false;
    }

    /**
     * Returns value of given cookie
     *
     * @param string $key
     * 
     * @return mixed
     */
    public static function get( string $key )
    {
        return $_COOKIE[$key];
    }

    /**
     * Creates new cookie.
     *
     * @param string $name
     * @param mixed $value
     * @param int $expiry
     * 
     * @return void
     */
    public static function put( string $name, $value, int $expiry = 0 )
    {
        setcookie($name, $value, time() + $expiry, '/', null, null, true);
    }

    /**
     * Deletes cookie
     *
     * @param string $key
     * 
     * @return void
     */
    public static function delete( string $key )
    {
        self::put($key, '', -3600);
    }

}
