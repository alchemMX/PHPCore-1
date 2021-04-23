<?php

namespace Block;

/**
 * Dropdown
 */
class Dropdown extends Block
{    
    /**
     * Return given dropdown
     *
     * @param  int $dropdownID
     * 
     * @return array
     */
    public function get( int $dropdownID )
    {
        return $this->db->query('SELECT * FROM ' . TABLE_BUTTONS . ' WHERE is_dropdown = 1 AND button_id = ?', [$dropdownID]);
    }
}