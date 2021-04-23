<?php

namespace Process\Pm;

class Leave extends \Process\ProcessExtend
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
        // DELETE RECIPIENT FROM PM
        $this->db->query('
            DELETE pmr FROM ' . TABLE_PRIVATE_MESSAGES_RECIPIENTS . '
            WHERE pm_id = ? AND user_id = ?
        ', [$this->data->get('pm_id'), LOGGED_USER_ID]);

        // REDIRECT USER
        $this->redirectTo('/user/pm/');
    }
}