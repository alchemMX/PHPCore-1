<?php

namespace Process\User;

use Model\Account\Login as ModelLogin;

class Login extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'user_name'     => [
                'type' => 'text',
                'required' => true
            ],
            'user_password' => [
                'type' => 'text',
                'required' => true
            ],
            'remember'      => [
                'type' => 'checkbox'
            ]
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'login' => REQUIRE_LOGOUT
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $login = new ModelLogin($this->data->get('user_name'), $this->data->get('user_password'), (int)$this->data->get('remember'));

        if ($login->login() === true) {
            session_regenerate_id(true);
        }

    }
}