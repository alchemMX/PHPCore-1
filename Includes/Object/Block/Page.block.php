<?php

namespace Block;

/**
 * Page
 */
class Page extends Block
{    
    /**
     * Returns custom page
     *
     * @param  int $pageID Page ID
     * 
     * @return array
     */
    public function get( int $pageID )
    {
        return $this->db->query('SELECT * FROM ' . TABLE_PAGES . ' WHERE page_id = ?', [$pageID]);
    }
    
    /**
     * Returns all custom pages
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('SELECT * FROM ' . TABLE_PAGES, [], ROWS);
    }
    
    /**
     * Returns id of all custom pages
     *
     * @return array
     */
    public function getAllID()
    {
        return array_column($this->db->query('SELECT * FROM ' . TABLE_PAGES, [], ROWS), 'page_id');
    }
}