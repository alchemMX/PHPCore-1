<?php

namespace Block;

/**
 * ConversationMessage
 */
class ConversationMessage extends Block
{
    /**
     * Returns message
     *
     * @param  int $conversationMessageID Conversation message ID
     * 
     * @return array
     */
    public function get( int $conversationMessageID )
    {
        return $this->db->query('
            SELECT cm.*, c.conversation_subject
            FROM ' . TABLE_CONVERSATIONS_MESSAGES . '
            LEFT JOIN ' . TABLE_CONVERSATIONS . ' ON c.conversation_id = cm.conversation_id
            WHERE conversation_message_id = ?', [$conversationMessageID]
        );
    }
    
    /**
     * Returns messages from conversation
     *
     * @param  int $conversationID Conversation ID
     * 
     * @return array
     */
    public function getParent( int $conversationID )
    {
        return $this->db->query('
            SELECT cm.*, c.conversation_subject, ' . $this->select->user() . ', group_name, user_last_activity, user_signature, user_topics, user_posts, user_reputation
            FROM ' . TABLE_CONVERSATIONS_MESSAGES . '
            LEFT JOIN ' . TABLE_CONVERSATIONS . ' ON c.conversation_id = cm.conversation_id
            ' . $this->join->user('cm.user_id'). '
            WHERE cm.conversation_id = ?
            ORDER BY conversation_message_id ASC
            LIMIT ?, ?',
        [$conversationID, $this->pagination['offset'], $this->pagination['max']], ROWS);
    }

     /**
     * Returns last messages from conversation
     *
     * @param int $conversationID Conversation ID
     * @param int $number Number of conversation messages
     * 
     * @return false
     */
    public function getLast( int $conversationID, int $number = 1 )
    {
        return $this->db->query('
            SELECT ' . $this->select->user() . '
            FROM ' . TABLE_CONVERSATIONS_MESSAGES . '
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = cm.user_id
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            WHERE cm.conversation_message_id = ?
            ORDER BY cm.conversation_message_id DESC
            LIMIT 0, ?',
        [$conversationID, $number]);
    }
}