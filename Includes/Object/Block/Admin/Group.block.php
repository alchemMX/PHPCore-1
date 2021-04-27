<?php

namespace Block\Admin;

/**
 * Group
 */
class Group extends \Block\Group
{
    /**
     * Returns group
     *
     * @param  int $groupID Group ID
     * 
     * @return array
     */
    public function get( int $groupID )
    {
        return $this->db->query('SELECT * FROM ' . TABLE_GROUPS . ' WHERE group_id = ? AND group_index < ?', [$groupID, LOGGED_USER_GROUP_INDEX]);
    }
    
    /**
     * Returns all groups
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('SELECT * FROM ' . TABLE_GROUPS . ' ORDER BY group_index DESC', [], ROWS);
    }
}