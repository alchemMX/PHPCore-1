<?php

namespace Process\Topic;

class Unlock extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'topic_id'
        ],
        'block' => [
            'user_id',
            'topic_name'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
        'verify' => [
            'block' => '\Block\Topic',
            'method' => 'get',
            'selector' => 'topic_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        // UNLOCK TOPIC
        $this->db->update(TABLE_TOPICS, [
            'is_locked' => '0'
        ], $this->data->get('topic_id'));

        // SEND NOTIFICATION
        $this->notifi(
            id: $this->data->get('topic_id'),
            to: $this->data->get('user_id'),
            replace: true
        );

        // ADD RECORD TO LOG
        $this->log($this->data->get('topic_name'));
    }
}