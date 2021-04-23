<?php

namespace Process\Post;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [

            // POST TEXT
            'text' => [
                'type' => 'html',
                'required' => true,
                'length_max' => 10000,
            ],
        ],
        'data' => [
            'post_id'
        ],
        'block' => [
            'user_id',
            'post_permission'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
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
        if (LOGGED_USER_ID != $this->data->get('user_id')) {
            return false;
        }

        if ($this->data->get('post_permission') != 1) {
            return false;
        }

        // EDITS POST
        $this->db->update(TABLE_POSTS, [
            'post_text' => $this->data->get('text'),
            'post_edited' => DATE_DATABASE,
            'is_edited' => '1'
        ], $this->data->get('post_id'));
    }
}