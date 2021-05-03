<?php

namespace Process\User;

/**
 * Signature
 */
class Signature extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'user_signature' => [
                'type' => 'html',
                'length_max' => 5000
            ]
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
        // SET SIGNATURE
        $this->db->update(TABLE_USERS, [
            'user_signature' => $this->data->get('user_signature')
        ], LOGGED_USER_ID);
    }
}