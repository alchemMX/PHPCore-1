<?php

namespace Process\User;

/**
 * Account
 */
class Account extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'user_name'                 => [
                'type' => 'username',
                'required' => true
            ],
            'user_email'                => [
                'type' => 'email',
                'required' => true
            ],
            'user_password_new'         => [
                'type' => 'password'
            ],
            'user_password_verify'      => [
                'type' => 'text'
            ],
            'user_password'             => [
                'type' => 'text',
                'required' => true
            ],
        ],
        'data' => [
            'current_user_password'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        if ($this->check->passwordMatch($this->data->get('user_password'), $this->data->get('current_user_password'))) {

            if ($this->data->get('user_password_new') and $this->data->get('user_password_verify')) {

                if ($this->check->passwordMatch($this->data->get('user_password_new'), $this->data->get('user_password_verify'))) {
                    
                    // UPDATE USER INFORMATIONS
                    $this->db->update(TABLE_USERS, [
                        'user_password' => password_hash($this->data->get('user_password_new'), PASSWORD_DEFAULT),
                    ], LOGGED_USER_ID);
                }
            }

            // UPDATE USER INFORMATIONS
            $this->db->update(TABLE_USERS, [
                'user_name' 	=> $this->data->get('user_name'),
                'user_email' 	=> $this->data->get('user_email')
            ], LOGGED_USER_ID);

            return true;

        }
    }
}