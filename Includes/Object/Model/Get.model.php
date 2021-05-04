<?php

namespace Model;

/**
 * Get
 */
class Get
{    
    /**
     * Return parameter from url
     *
     * @param  string $key
     * 
     * @return string
     */
    public function get( string $key )
    {
        return preg_replace("/[^A-Za-z0-9_\/]/", '', $_GET[$key] ?? '');
    }
    
    /**
     * Checks if given parameter is in url
     *
     * @param  string $key
     * 
     * @return bool
     */
    public function is( string $key )
    {
        return isset($_GET[$key]);
    }
}