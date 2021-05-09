<?php

namespace Exception;

/**
 * Notice exception
 */
class Notice extends \Exception {

    /**
     * Construct
     *
     * @param string $notice Notice
     */
    public function __construct( string $notice )
    {
        global $router;
        $router->notice($notice);
        exit();
    }
}