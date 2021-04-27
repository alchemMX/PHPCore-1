<?php

namespace Process\ProfilePost;

class Create extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [

            // PROFILE POST TEXT
            'text' => [
                'type' => 'html',
                'required' => true,
                'length_max' => 5000,
            ]
        ],
        'data' => [
            'user_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
        'verify' => [
            'block' => '\Block\User',
            'method' => 'get',
            'selector' => 'user_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->insert(TABLE_PROFILE_POSTS, [
            'user_id'           => LOGGED_USER_ID,
            'profile_id'        => $this->data->get('user_id'),
            'profile_post_text' => $this->data->get('text')
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