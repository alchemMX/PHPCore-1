<?php

namespace Exception;

/**
 * Notice exception
 */
class Notice extends \Exception
{
    /**
     * Constructor
     *
     * @param string $notice
     * @param array $assign
     */
    public function __construct( string $notice, array $assign = [] )
    {
        global $router;
        $router->notice($notice, $assign);
        exit();
    }
}