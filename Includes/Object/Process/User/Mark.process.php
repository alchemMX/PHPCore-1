<?php

namespace Process\User;

class Mark extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [];

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
        // MARK ALL USER NOTIFICATIONS AD READ
        $this->db->query('
            DELETE un FROM ' . TABLE_USERS_NOTIFICATIONS . '
            WHERE to_user_id = ?
        ', [LOGGED_USER_ID]);
    }
}