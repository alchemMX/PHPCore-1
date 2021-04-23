<?php

namespace Process\Admin\Category;

class Down extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'category_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\Admin\Category',
            'method' => 'get',
            'selector' => 'category_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('
            UPDATE ' . TABLE_CATEGORIES . '
            LEFT JOIN ' . TABLE_CATEGORIES . '2 ON c2.position_index = c.position_index - 1
            SET c.position_index = c.position_index - 1,
                c2.position_index = c2.position_index + 1
            WHERE c.category_id = ? AND c2.category_id IS NOT NULL
        ', [$this->data->get('category_id')]);

        // ADD RECORD TO LOG
        $this->log();
    }
}