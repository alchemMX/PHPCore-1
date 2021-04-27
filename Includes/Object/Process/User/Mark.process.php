<?php

namespace Process\User;

class Mark extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [];

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
        // MARK ALL USER NOTIFICATIONS AD READ
        $this->db->query('
            DELETE un FROM ' . TABLE_USERS_NOTIFICATIONS . '
            WHERE to_user_id = ?
        ', [LOGGED_USER_ID]);
    }
}