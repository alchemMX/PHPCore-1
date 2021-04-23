<?php

namespace Block;

/**
 * Notification
 */
class Notification extends Block
{    
    /**
     * Return notification
     *
     * @param  int $notificationID
     * 
     * @return array
     */
    public function get( int $notificationID )
    {
        return $this->db->query('SELECT * FROM ' . TABLE_NOTIFICATIONS . ' WHERE notification_id = ?', [$notificationID]);
    }

    /**
     * Returns all notifications
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('SELECT * FROM ' . TABLE_NOTIFICATIONS . ' WHERE is_hidden = 0 ORDER BY position_index DESC', [], ROWS);
    }
}