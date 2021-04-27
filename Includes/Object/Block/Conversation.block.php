<?php

namespace Block;

/**
 * Conversation
 */
class Conversation extends Block
{    
    /**
     * Returns conversation
     *
     * @param  int $conversationID Conversation ID
     * 
     * @return array
     */
    public function get( int $conversationID )
    {
        return $this->db->query('
            SELECT c.*, ' . $this->select->user() . ', user_last_activity, user_signature, group_name, user_topics, user_posts, user_reputation
            FROM ' . TABLE_CONVERSATIONS . '
            ' . $this->join->user('c.user_id'). '
            LEFT JOIN ' . TABLE_CONVERSATIONS_RECIPIENTS . ' ON cr.conversation_id = c.conversation_id
            WHERE c.conversation_id = ? AND cr.user_id = ?
            GROUP BY c.conversation_id',
        [$conversationID, LOGGED_USER_ID]);
    }
    
    /**
     * Returns all conversations
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('
            SELECT c.*, ' . $this->select->user() . '
            FROM ' . TABLE_CONVERSATIONS . '
            ' . $this->join->user('c.user_id'). '
            LEFT JOIN ' . TABLE_CONVERSATIONS_RECIPIENTS . ' ON cr.conversation_id = c.conversation_id
            WHERE cr.user_id = ?
            GROUP BY c.conversation_id
            ORDER BY conversation_id DESC
            LIMIT ?, ?',
        [LOGGED_USER_ID, $this->pagination['offset'], $this->pagination['max']], ROWS);
    }
    
    /**
     * Returns count of conversations
     *
     * @return int
     */
    public function getAllCount()
    {
        return  (int)$this->db->query('
            SELECT IFNULL(COUNT(*), 0) as count
            FROM ' . TABLE_CONVERSATIONS . '
            LEFT JOIN ' . TABLE_CONVERSATIONS_RECIPIENTS . ' ON cr.conversation_id = c.conversation_id
            WHERE cr.user_id = ?
            GROUP BY c.conversation_id
        ',[LOGGED_USER_ID])??['count'];
    }
    
    /**
     * Returns recipients of conversation
     *
     * @param  int $conversationID Conversation ID
     * 
     * @return array
     */
    public function getRecipients( int $conversationID )
    {
        return $this->db->query('
            SELECT ' . $this->select->user() . ', group_name
            FROM ' . TABLE_CONVERSATIONS_RECIPIENTS . '
            ' . $this->join->user('cr.user_id'). '
            WHERE cr.conversation_id = ?',
        [$conversationID], ROWS);
    }
}