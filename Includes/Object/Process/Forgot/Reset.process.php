<?php

namespace Process\Forgot;

class Reset extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'user_password'         => [
                'type' => 'text',
                'required' => true
            ],
            'user_password_verify'  => [
                'type' => 'text',
                'required' => true
            ]
        ],
        'data' => [
            'user_id'
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
        // IF PASSWORDS MATCH
        if ($this->check->passwordMatch($this->data->get('user_password'), $this->data->get('user_password_verify'))) {

            // IF IS PASSWORD VALID
            if ($this->check->password($this->data->get('user_password'))) {

                // UPDATE PASSWORD IN DATABASE
                $this->db->update(TABLE_USERS, [
                    'user_password' => password_hash($this->data->get('user_password'), PASSWORD_DEFAULT),
                ], $this->data->get('user_id'));

                // DELETE RECORD FROM "FORGOT PASSWORD" TABLE                  
                $this->db->query('DELETE fp FROM ' . TABLE_FORGOT . ' WHERE user_id = ?', [$this->data->get('user_id')]);
    
                return true;
            }
        }
    }
}