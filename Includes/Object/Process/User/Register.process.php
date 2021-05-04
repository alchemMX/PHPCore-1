<?php

namespace Process\User;

use Model\Account\Register as ModelRegister;
use Model\Mail\MailRegister;

/**
 * Register
 */
class Register extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'user_name'             => [
                'type' => 'username',
                'required' => true
            ],
            'user_email'            => [
                'type' => 'email',
                'required' => true
            ],
            'user_password'         => [
                'type' => 'password',
                'required' => true
            ],
            'user_password_verify'  => [
                'type' => 'text',
                'required' => true
            ],
            'agree'                 => [
                'type' => 'checkbox',
                'required' => true
            ],
            'token'                 => [
                'type' => 'text',
                'required' => true
            ],
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
        'login' => REQUIRE_LOGOUT
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        if ($this->check->passwordMatch($this->data->get('user_password'), $this->data->get('user_password_verify'))) {

            $register = new ModelRegister(
                $this->data->get('user_name'),
                $this->data->get('user_password'),
                $this->data->get('user_email'),
                $this->data->get('token')
            );

            // IF REGISTER IS VALID
            if ($register->register() === true) {

                // SEND AN EMAIL TO VERIFY ACCOUNT
                $mail = new MailRegister();
                $mail->mail->addAddress($this->data->get('user_email'), $this->data->get('user_name'));
                $mail->assign(['code' => $register->getCode()]);
                $mail->send();

                return true;
            }
        }
    }
}