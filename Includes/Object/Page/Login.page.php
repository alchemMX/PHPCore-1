<?php

namespace Page;

use Block\User;

use Visualization\Field\Field;

/**
 * Login page
 */
class Login extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
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

        if ($this->getOperation() === 'send') {

            if ($data = (new User)->get($this->getParam('send'))) {

                if ($data['verify_code']) {

                    // RESEND VERIFY EMAIL
                    $this->process->call(type: 'Verify/Send', data: [
                        'verify_code'   => $data['verify_code'],
                        'user_email'    => $data['user_email']
                    ]);
                }
            }
        }
    }
}