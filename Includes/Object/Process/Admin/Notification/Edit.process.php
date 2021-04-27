<?php

namespace Process\Admin\Notification;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'notification_name' => [
                'type' => 'text',
                'required' => true
            ],
            'notification_text' => [
                'type' => 'text',
                'required' => true
            ],
            'notification_type' => [
                'custom' => [1, 2, 3]
            ],
            'is_hidden' => [
                'type' => 'checkbox'
            ]
        ],
        'data' => [
            'notification_id'
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
        // EDIT NOTIFICATION
        $this->db->update(TABLE_NOTIFICATIONS, [
            'is_hidden'             => $this->data->get('is_hidden'),
            'notification_name'     => $this->data->get('notification_name'),
            'notification_text'     => $this->data->get('notification_text'),
            'notification_type'     => $this->data->get('notification_type')
        ], $this->data->get('notification_id'));

        // ADD RECORD TO LOG
        $this->log($this->data->get('notification_name'));
    }
}