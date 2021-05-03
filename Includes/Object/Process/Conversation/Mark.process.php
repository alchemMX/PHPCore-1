<?php

namespace Process\Conversation;

/**
 * Mark
 */
class Mark extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'conversation_id'
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
        $this->db->insert(TABLE_USERS_UNREAD, [
            'conversation_id' => $this->data->get('conversation_id'),
            'user_id' => LOGGED_USER_ID
        ]);
        $this->redirectTo('/user/conversation/');
    }
}