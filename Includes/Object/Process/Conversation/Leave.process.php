<?php

namespace Process\Conversation;

class Leave extends \Process\ProcessExtend
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
        // DELETE RECIPIENT FROM CONVERSATION
        $this->db->query('
            DELETE cr FROM ' . TABLE_CONVERSATIONS_RECIPIENTS . '
            WHERE conversation_id = ? AND user_id = ?
        ', [$this->data->get('conversation_id'), LOGGED_USER_ID]);

        // REDIRECT USER
        $this->redirectTo('/user/conversation/');
    }
}