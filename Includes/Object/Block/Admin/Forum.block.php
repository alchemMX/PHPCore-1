<?php

namespace Block\Admin;

/**
 * Forum
 */
class Forum extends \Block\Forum
{    
    /**
     * Returns forum
     *
     * @param  int $forumID Forum ID
     * 
     * @return array
     */
    public function get( int $forumID )
    {
        return $this->db->query('SELECT * FROM ' . TABLE_FORUMS . ' WHERE f.forum_id = ?', [$forumID]);
    }

    /**
     * Returns all forums
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('SELECT * FROM ' . TABLE_FORUMS, [], ROWS);
    }
    
    /**
     * Returns id of all forums
     *
     * @return array
     */
    public function getAllID()
    {
        return array_column($this->db->query('SELECT * FROM ' . TABLE_FORUMS, [], ROWS), 'forum_id');
    }

    /**
     * Returns forums from category
     *
     * @param  int $categoryID Category ID
     * 
     * @return array
     */
    public function getParent( int $categoryID )
    {
        return $this->db->query('
            SELECT f.forum_id, forum_name, forum_url, forum_description, is_main, forum_icon_style, forum_icon_name
            FROM ' . TABLE_FORUMS . '
            WHERE f.category_id = ?
            GROUP BY f.forum_id
            ORDER BY position_index DESC
        ', [$categoryID], ROWS);
    }

    /**
     * Returns forum stats
     *
     * @return array
     */
    public function getStats()
    {
        return $this->db->query('
            SELECT (
                SELECT COUNT(*)
                FROM ' . TABLE_POSTS . '
            ) as post, (
                SELECT COUNT(*)
                FROM ' . TABLE_TOPICS . '
            ) as topic, (
                SELECT COUNT(*)
                FROM ' . TABLE_USERS . '
                WHERE u.is_deleted = 0
            ) as user
        ');
    }
}