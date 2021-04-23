<?php

namespace Block;

/**
 * UserNotification
 */
class UserNotification extends Block
{    
    /**
     * Returns users notifications
     *
     * @param  int $userID
     * 
     * @return array
     */
    public function getParent( int $userID )
    {
        return $this->db->query('
            SELECT un.*, ' . $this->select->user() . '
            FROM ' . TABLE_USERS_NOTIFICATIONS . '
            ' . $this->join->user('un.user_id'). '
            WHERE un.to_user_id = ?
            ORDER BY user_notification_id DESC',
        [$userID], ROWS);
    }
}