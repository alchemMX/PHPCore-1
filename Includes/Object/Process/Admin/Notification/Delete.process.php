<?php

namespace Process\Admin\Notification;

/**
 * Delete
 */
class Delete extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'notification_id'
        ],
        'block' => [
            'notification_name'
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
            LEFT JOIN ' . TABLE_NOTIFICATIONS . '2 ON n2.position_index > n.position_index
            SET n2.position_index = n2.position_index - 1
            WHERE n.notification_id = ?
        ', [$this->data->get('notification_id')]);

        $this->db->query('DELETE n FROM ' . TABLE_NOTIFICATIONS . ' WHERE notification_id = ?', [$this->data->get('notification_id')]);
    
        // ADD RECORD TO LOG
        $this->log($this->data->get('notification_name'));
    }
}