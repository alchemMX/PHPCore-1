<?php

namespace Process\Message;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            
            // MESSAGE TEXT
            'text'  => [
                'type' => 'html',
                'required' => true,
                'length_max' => 10000,
            ]
        ],
        'data' => [
            'message_id'
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
            'block' => '\Block\Message',
            'method' => 'get',
            'selector' => 'message_id'
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

        // EDIT MESSAGE
        $this->db->update(TABLE_MESSAGES, [
            'is_edited' => '1',
            'message_text'	=> $this->data->get('text'),
            'message_edited' => DATE_DATABASE
        ], $this->data->get('message_id'));

        return true;
    }
}