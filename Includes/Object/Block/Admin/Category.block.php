<?php

namespace Block\Admin;

/**
 * Category
 */
class Category extends \Block\Category {

    /**
     * Returns category
     * 
     * @param int $categoryID Category ID
     *
     * @return array
     */
    public function get( int $categoryID )
    {
        return $this->db->query('SELECT * FROM ' . TABLE_CATEGORIES . ' WHERE category_id = ?', [$categoryID]);
    }

    /**
     * Returns id of all categories
     * 
     * @return array
     */
    public function getAllID()
    {
        return array_column($this->db->query('SELECT * FROM ' . TABLE_CATEGORIES . ' ORDER BY position_index DESC', [], ROWS), 'category_id');
    }

    /**
     * Returns all categories
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('SELECT * FROM ' . TABLE_CATEGORIES . ' ORDER BY position_index DESC', [], ROWS);
    }
}
