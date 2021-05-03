<?php

namespace Page;

/**
 * Verify
 */
class Verify extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'id' => string,
        'loggedOut' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // VERIFY USER
        $this->process->call(type: 'User/Verify', mode: 'silent', url: '/', data: [
            'verify_code' => $this->getID()
        ]);
    }
}