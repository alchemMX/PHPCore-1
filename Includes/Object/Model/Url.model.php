<?php

namespace Model;

/**
 * Url
 */
class Url 
{
    /**
     * @var array $URL Parsed URL
     */
    private array $URL = [];
    
    /**
     * Constructor
     *
     * @param  array $URL
     */
    public function __construct( array $URL )
    {
        $this->URL = $URL;    
    }

    /**
     * Checks if parameter in URL exists
     *
     * @param string $parameter Prameter name
     * 
     * @return bool
     */
    public function is( string $parameter )
    {
        foreach ($this->URL as $param) {
            if (explode('-', $param)[0] == $parameter) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Returns value from URL parameter
     *
     * @param string $parameter Prameter name
     * 
     * @return string
     */
    public function get( string $parameter )
    {
        foreach ($this->URL as $param) {
            if (($ex = explode('-', $param))[0] == $parameter) {
                return trim(strip_tags($ex[1] ?? ''));
            }
        }
        return '';
    }
}
