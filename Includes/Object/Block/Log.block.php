<?php

namespace Block;

/**
 * Log
 */
class Log extends Block
{    
    /**
     * Returns all records from audit log
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('
            SELECT *
            FROM ' . TABLE_LOG . '
            ' . $this->join->user('lg.user_id'). '
            ORDER BY log_id DESC
            LIMIT ?, ?
        ',[$this->pagination['offset'], $this->pagination['max']], ROWS);
    }

    /**
     * Returns count of records from audit log
     * 
     * @return int
     */
    public function getAllCount()
    {
        return (int)$this->db->query('SELECT COUNT(*) as count FROM ' . TABLE_LOG)['count'];
    }

    /**
     * Returns last records from audit log
     *
     * @param int $number Number of records
     * 
     * @return array
     */
    public function getLast( int $number = 5 )
    {
        return $this->db->query('
            SELECT *
            FROM ' . TABLE_LOG . '
            ' . $this->join->user('lg.user_id'). '
            ORDER BY log_id DESC
            LIMIT ?
        ',[$number], ROWS);
    }
}