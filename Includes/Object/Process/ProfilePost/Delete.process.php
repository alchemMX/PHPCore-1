<?php

namespace Process\ProfilePost;

class Delete extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'profile_post_id'
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
            'block' => '\Block\ProfilePost',
            'method' => 'get',
            'selector' => 'profile_post_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->insert(TABLE_DELETED_CONTENT, [
            'user_id' => LOGGED_USER_ID,
            'deleted_type' => 'ProfilePost',
            'deleted_type_id' => $this->data->get('profile_post_id'),
            'deleted_type_user_id' => $this->data->get('user_id')
        ]);

        $this->id = $this->db->lastInsertID();

        $this->db->query('
            UPDATE ' . TABLE_PROFILE_POSTS . ' SET deleted_id = ? WHERE profile_post_id = ?
        ', [$this->id, $this->data->get('profile_post_id')]);

        // SEND USER NOTIFICATION
        $this->notifi(
            id: $this->data->get('profile_post_id'),
            to: $this->data->get('user_id')
        );

        // ADD RECORD TO LOG
        $this->log();
    }
}