<?php

namespace Process\Topic;

/**
 * Unlike
 */
class Unlike extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
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
        if (LOGGED_USER_ID == $this->data->get('user_id')) {
            return false;
        }

        if (!in_array(LOGGED_USER_ID, array_column((new \Block\Topic)->getLikes($this->data->get('topic_id')), 'user_id'))) {
            return false;
        }

        // UNLIKE TOPIC
        $this->db->query('
            DELETE tl FROM ' . TABLE_TOPICS_LIKES . '
            WHERE topic_id = ? AND user_id = ?
        ', [$this->data->get('topic_id'), LOGGED_USER_ID]);

        // REDUCES USER REPUTATION
        $this->db->update(TABLE_USERS, [
            'user_reputation' => [MINUS]
        ], $this->data->get('user_id'));

        // DELETE OLD USER NOTIFICATION
        $this->db->query('
            DELETE un FROM ' . TABLE_USERS_NOTIFICATIONS . '
            WHERE to_user_id = ? AND user_notification_type = "Topic/Like" AND user_notification_type_id = ?
        ', [$this->data->get('user_id'), $this->data->get('topic_id')]);
    }
}