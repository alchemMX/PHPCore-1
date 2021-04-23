<?php

namespace Model;

/**
 * Get
 */
class Get
{    
    /**
     * Return param from url
     *
     * @param  string $key
     * 
     * @return string
     */
    public function get( string $key )
    {
        if (isset($_GET[$key])) {
            return preg_replace("/[^A-Za-z0-9_\/]/", '', $_GET[$key]);
        }
        return '';
    }
    
    /**
     * Checks if given param is in url
     *
     * @param  mixed $key
     * 
     * @return bool
     */
    public function is( string $key )
    {
        return isset($_GET[$key]) ? true : false;
    }
}