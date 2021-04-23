<?php

namespace Model;

/**
 * Session class
 */
class Session 
{
    /**
     * Checks if given session exists
     *
     * @param string $key
     * 
     * @return bool
     */
    public static function exists( string $key )
    {
        return isset($_SESSION[$key]) ? true : false;
    }
    
    /**
     * Returns value of given session.
     *
     * @param string $key
     * 
     * @return string
     */
    public static function get( string $key )
    {
        return $_SESSION[$key] ?? '';
    }

    /**
     * Creates new session
     *
     * @param string $name
     * @param mixed $value
     * 
     * @return void
     */
    public static function put( string $name, mixed $value )
    {
        $_SESSION[$name] = $value;
    }

    /**
     * Deletes session
     *
     * @param string $name
     * 
     * @return void
     */
    public static function delete( string $name )
    {
        unset($_SESSION[$name]);
    }
}
