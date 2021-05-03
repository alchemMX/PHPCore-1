<?php

namespace Page;

/**
 * Logout
 */
class Logout extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'loggedIn' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // LOGOUT USER
        $this->process->call(type: 'User/Logout', url: '/');
    }
}