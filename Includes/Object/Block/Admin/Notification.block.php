<?php

namespace Block\Admin;

/**
 * Notification
 */
class Notification extends \Block\Notification
{    
    /**
     * Returns all notifications
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('SELECT * FROM ' . TABLE_NOTIFICATIONS . ' ORDER BY position_index DESC', [], ROWS);
    }
}