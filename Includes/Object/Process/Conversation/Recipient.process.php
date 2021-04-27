<?php

namespace Process\Conversation;

class Recipient extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'conversation_id',
            'user_id',
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->insert(TABLE_CONVERSATIONS_RECIPIENTS, [
            'conversation_id' => $this->data->get('conversation_id'),
            'user_id' => $this->data->get('user_id')
        ]);

        $this->db->insert(TABLE_USERS_UNREAD, [
            'conversation_id' => $this->data->get('conversation_id'),
            'user_id' => $this->data->get('user_id')
        ]);
    }
}