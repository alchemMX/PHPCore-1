<?php

namespace Process\ProfilePost;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [

            // PROFILE POST TEXT
            'text' => [
                'type' => 'html',
                'required' => true,
                'length_max' => 5000,
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
        if (LOGGED_USER_ID != $this->data->get('user_id')) {
            return false;
        }

        // UPDATE PROFILE POST
        $this->db->update(TABLE_PROFILE_POSTS, [
            'is_edited' => '1',
            'profile_post_text' => $this->data->get('text'),
            'profile_post_edited' => DATE_DATABASE
        ], $this->data->get('profile_post_id'));

        return true;
    }
}