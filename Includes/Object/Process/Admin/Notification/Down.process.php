<?php

namespace Process\Admin\Notification;

class Down extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'notification_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
        'verify' => [
            'block' => '\Block\Notification',
            'method' => 'get',
            'selector' => 'notification_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('
            UPDATE ' . TABLE_NOTIFICATIONS . '
            LEFT JOIN ' . TABLE_NOTIFICATIONS . '2 ON n2.position_index = n.position_index - 1
            SET n.position_index = n.position_index - 1,
                n2.position_index = n2.position_index + 1
            WHERE n.notification_id = ? AND n2.notification_id IS NOT NULL
        ', [$this->data->get('notification_id')]);

        // ADD RECORD TO LOG
        $this->log();
    }
}