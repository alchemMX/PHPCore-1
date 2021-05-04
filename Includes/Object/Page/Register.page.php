<?php

namespace Page;

use Visualization\Field\Field;

/**
 * Register
 */
class Register extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'template' => 'Register',
        'loggedOut' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // IF REGISTRATION ISN'T ALLOWED
        $this->system->settings->get('registration.enabled') == 1 or redirect('/');

        // FIELD
        $field = new Field('User/Register');
        $this->data->field = $field->getData();

        // REGISTER USER
        $this->process->form(type: 'User/Register', url: '/');
    }
}