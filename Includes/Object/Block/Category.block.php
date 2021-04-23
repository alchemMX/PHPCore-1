<?php

namespace Block;

/**
 * Category
 */
class Category extends Block
{
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
     * Returns all categories
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('
            SELECT c.category_id, category_name, category_description
            FROM ' . TABLE_CATEGORIES . '
            LEFT JOIN ' . TABLE_CATEGORIES_PERMISSION_SEE . ' ON cps.category_id = c.category_id AND cps.group_id = ' . LOGGED_USER_GROUP_ID . '
            WHERE cps.category_id IS NOT NULL
            GROUP BY c.category_id 
            ORDER BY c.position_index DESC
        ', [], ROWS);
    }
    
    /**
     * Returns id of all groups which has permission to see category
     *
     * @param  int $categoryID
     * 
     * @return array
     */
    public function getSee( int $categoryID )
    {
        return array_column($this->db->query('SELECT group_id FROM ' . TABLE_CATEGORIES_PERMISSION_SEE . ' WHERE category_id = ?', [$categoryID], ROWS), 'group_id');
    }
}
