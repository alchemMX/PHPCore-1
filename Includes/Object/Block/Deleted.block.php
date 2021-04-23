<?php

namespace Block;

/**
 * Deleted
 */
class Deleted extends Block
{
    /**
     * Returns deleted content details
     *
     * @param  int $deletedID Deleted ID
     * 
     * @return array
     */
    public function get( $deletedID )
    {
        return $this->db->query('
            SELECT *
            FROM ' . TABLE_DELETED_CONTENT . '
            ' . $this->join->user('dc.user_id'). '
            WHERE deleted_id = ?
        ', [$deletedID]);
    }

    /**
     * Returns all deleted content
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('
            SELECT dc.*, ' . $this->select->user() . '
            FROM ' . TABLE_DELETED_CONTENT . '
            ' . $this->join->user('dc.deleted_type_user_id'). '
            ORDER BY deleted_time DESC
            LIMIT ?, ?
        ', [$this->pagination['offset'], $this->pagination['max']], ROWS);
    }

    /**
     * Returns count of all deleted content
     *
     * @return int
     */
    public function getAllCount()
    {
        return (int)$this->db->query('
            SELECT COUNT(*) AS count
            FROM ' . TABLE_DELETED_CONTENT . '
        ')['count'];
    }
}