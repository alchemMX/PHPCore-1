<?php

namespace Page;

use Visualization\Field\Field;

/**
 * Login
 */
class Login extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'template' => 'Login',
        'loggedOut' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // FIELD
        $field = new Field('User/Login');
        $this->data->field = $field->getData();

        // LOGIN USER
        $this->process->form(type: 'User/Login', url: '/');
    }
}