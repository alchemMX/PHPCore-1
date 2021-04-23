<?php

namespace Block;

/**
 * Button
 */
class Button extends Block
{   
    /**
     * Return button
     *
     * @param  int $buttonID
     * 
     * @return array
     */
    public function get( int $buttonID )
    {
        return $this->db->query('SELECT * FROM ' . TABLE_BUTTONS . ' WHERE button_id = ?', [$buttonID]);
    }
    
    /**
     * Returns all buttons 
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('
            SELECT *, IFNULL(page_url, button_link) AS button_link
            FROM ' . TABLE_BUTTONS . '
            LEFT JOIN ' . TABLE_PAGES . ' ON pg.page_id = b.page_id
            ORDER By position_index DESC
        ', [], ROWS);
    }
}