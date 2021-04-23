<?php

namespace Process\Topic;

class Like extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'topic_id'
        ],
        'block' => [
            'user_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
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
        if (LOGGED_USER_ID == $this->data->get('user_id')) {
            return;
        }

        if (in_array(LOGGED_USER_ID, array_column((new \Block\Topic)->getLikes($this->data->get('topic_id')), 'user_id'))) {
            return false;
        }

        // LIKES TOPIC
        $this->db->insert(TABLE_TOPICS_LIKES, [
            'topic_id' => $this->data->get('topic_id'),
            'user_id' => LOGGED_USER_ID
        ]);

        // ADDS REPUTATION
        $this->db->update(TABLE_USERS, [
            'user_reputation' => [PLUS]
        ],$this->data->get('user_id'));

        // SEND NOTIFICATION
        $this->notifi(
            id: $this->data->get('topic_id'),
            to: $this->data->get('user_id'),
            replace: true
        );
    }
}