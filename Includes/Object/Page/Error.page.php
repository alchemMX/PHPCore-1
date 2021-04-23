<?php

namespace Page;

/**
 * Error page
 */
class Error extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Error'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body() {}
}