<?php

namespace Exception;

use Model\Language;

/**
 * Notice exception
 */
class Notice extends \Exception {

    /**
     * Constructor
     *
     * @param string $message
     * @param array $assign
     */
    public function __construct( string $notice, array $assign = [] )
    {
        global $router;
        $router->notice($notice, $assign);
        exit();
    }
}