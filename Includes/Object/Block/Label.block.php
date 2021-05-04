<?php

namespace Block;

/**
 * Label
 */
class Label extends Block
{
    /**
     * Returns label
     * 
     * @param int $labelID Label ID
     * 
     * @return array
     */
    public function get( int $labelID )
    {
        return $this->db->query('SELECT label_id, label_name, label_class_name, label_color FROM ' . TABLE_LABELS . ' WHERE label_id = ?', [$labelID]);
    }

    /**
     * Returns all labels
     * 
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('SELECT * FROM ' . TABLE_LABELS . ' ORDER BY position_index DESC', [], ROWS);
    }

    /**
     * Returns id of all labels
     * 
     * @return array
     */
    public function getAllID()
    {
        return array_column($this->db->query('SELECT label_id FROM ' . TABLE_LABELS, [], ROWS), 'label_id');
    }
}