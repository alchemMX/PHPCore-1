<?php

namespace Block;

/**
 * Pm block
 */
class Pm extends Block
{    
    /**
     * Returns private message
     *
     * @param  int $pmID Private message id
     * 
     * @return array
     */
    public function get( int $pmID )
    {
        return $this->db->query('
            SELECT pm.*, ' . $this->select->user() . ', user_last_activity, user_signature, group_name, user_topics, user_posts, user_reputation
            FROM ' . TABLE_PRIVATE_MESSAGES . '
            ' . $this->join->user('pm.user_id'). '
            LEFT JOIN ' . TABLE_PRIVATE_MESSAGES_RECIPIENTS . ' ON pmr.pm_id = pm.pm_id
            WHERE pm.pm_id = ? AND pmr.user_id = ?
            GROUP BY pm.pm_id',
        [$pmID, LOGGED_USER_ID]);
    }
    
    /**
     * Returns all private messages
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('
            SELECT pm.*, ' . $this->select->user() . '
            FROM ' . TABLE_PRIVATE_MESSAGES . '
            ' . $this->join->user('pm.user_id'). '
            LEFT JOIN ' . TABLE_PRIVATE_MESSAGES_RECIPIENTS . ' ON pmr.pm_id = pm.pm_id
            WHERE pmr.user_id = ?
            GROUP BY pm.pm_id
            ORDER BY pm_id DESC
            LIMIT ?, ?',
        [LOGGED_USER_ID, $this->pagination['offset'], $this->pagination['max']], ROWS);
    }
    
    /**
     * Returns count of private messages
     *
     * @return int
     */
    public function getAllCount()
    {
        return  (int)$this->db->query('
            SELECT IFNULL(COUNT(*), 0) as count
            FROM ' . TABLE_PRIVATE_MESSAGES . '
            LEFT JOIN ' . TABLE_PRIVATE_MESSAGES_RECIPIENTS . ' ON pmr.pm_id = pm.pm_id
            WHERE pmr.user_id = ?
            GROUP BY pm.pm_id
        ',[LOGGED_USER_ID])??['count'];
    }
    
    /**
     * Returns recipients of private message
     *
     * @param  int $pmID
     * 
     * @return array
     */
    public function getRecipients( int $pmID )
    {
        return $this->db->query('
            SELECT ' . $this->select->user() . ', group_name
            FROM ' . TABLE_PRIVATE_MESSAGES_RECIPIENTS . '
            ' . $this->join->user('pmr.user_id'). '
            WHERE pmr.pm_id = ?',
        [$pmID], ROWS);
    }
}