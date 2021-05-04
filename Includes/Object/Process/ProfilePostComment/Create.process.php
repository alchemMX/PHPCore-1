<?php

namespace Process\ProfilePostComment;

/**
 * Create
 */
class Create extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [

            // PROFILE COMMENT TEXT
            'text' => [
                'type' => 'html',
                'required' => true,
                'length_max' => 5000
            ]
        ],
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
    public array $options = [
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
        // CREATES NEW PROFILE SUB POST
        $this->db->insert(TABLE_PROFILE_POSTS_COMMENTS, [
            'user_id'               => LOGGED_USER_ID,
            'profile_post_id'       => $this->data->get('profile_post_id'),
            'profile_post_comment_text' => $this->data->get('text')
        ]);

        $this->id = $this->db->lastInsertId();

        // SEND USER NOTIFICATION
        $this->notifi(
            id: $this->db->lastInsertId(),
            to: $this->data->get('user_id')
        );

        return true;
    }
}