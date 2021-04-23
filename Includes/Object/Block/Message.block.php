<?php

namespace Block;

/**
 * Message
 */
class Message extends Block
{
    /**
     * Returns message
     *
     * @param  int $messageID
     * 
     * @return array
     */
    public function get( int $messageID )
    {
        return $this->db->query('SELECT m.*, pm.pm_subject FROM ' . TABLE_MESSAGES . ' LEFT JOIN ' . TABLE_PRIVATE_MESSAGES . ' ON pm.pm_id = m.pm_id WHERE message_id = ?', [$messageID]);
    }
    
    /**
     * Returns messages from private message
     *
     * @param  int $pmID
     * 
     * @return array
     */
    public function getParent( int $pmID )
    {
        return $this->db->query('
            SELECT m.*, pm.pm_subject, ' . $this->select->user() . ', group_name, user_last_activity, user_signature, user_topics, user_posts, user_reputation
            FROM ' . TABLE_MESSAGES . '
            LEFT JOIN ' . TABLE_PRIVATE_MESSAGES . ' ON pm.pm_id = m.pm_id
            ' . $this->join->user('m.user_id'). '
            WHERE m.pm_id = ?
            ORDER BY message_id ASC
            LIMIT ?, ?',
        [$pmID, $this->pagination['offset'], $this->pagination['max']], ROWS);
    }

     /**
     * Returns last messages from private message
     *
     * @param int $pmID Private messaged ID
     * @param int $number Number of messages
     * 
     * @return false
     */
    public function getLast( int $pmID, int $number = 1 )
    {
        return $this->db->query('
            SELECT ' . $this->select->user() . '
            FROM ' . TABLE_MESSAGES . '
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = m.user_id
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            WHERE m.pm_id = ?
            ORDER BY message_id DESC
            LIMIT 0, ?',
        [$pmID, $number]);
    }
}