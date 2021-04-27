<?php

namespace Process\Post;

class Like extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'post_id'
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
            'block' => '\Block\Post',
            'method' => 'get',
            'selector' => 'post_id'
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

        if (in_array(LOGGED_USER_ID, array_column((new \Block\Post)->getLikes($this->data->get('post_id')), 'user_id'))) {
            return false;
        }

        // LIKES POST
        $this->db->insert(TABLE_POSTS_LIKES, [
            'post_id' => $this->data->get('post_id'),
            'user_id' => LOGGED_USER_ID
        ]);

        // ADDS REPUTATION
        $this->db->update(TABLE_USERS, [
            'user_reputation' => [PLUS],
        ], $this->data->get('user_id'));

        // SEND USER NOTIFICATION
        $this->notifi(
            id: $this->data->get('post_id'),
            to: $this->data->get('user_id')
        );
    }
}