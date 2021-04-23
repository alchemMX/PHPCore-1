<?php

namespace Process\Pm;

class Recipient extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'pm_id',
            'user_id',
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
        $this->db->insert(TABLE_PRIVATE_MESSAGES_RECIPIENTS, [
            'pm_id' => $this->data->get('pm_id'),
            'user_id' => $this->data->get('user_id')
        ]);

        $this->db->insert(TABLE_USERS_UNREAD, [
            'pm_id' => $this->data->get('pm_id'),
            'user_id' => $this->data->get('user_id')
        ]);
    }
}