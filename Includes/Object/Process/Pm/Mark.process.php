<?php

namespace Process\Pm;

class Mark extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'pm_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->insert(TABLE_USERS_UNREAD, [
            'pm_id' => $this->data->get('pm_id'),
            'user_id' => LOGGED_USER_ID
        ]);
        $this->redirectTo('/user/pm/');
    }
}