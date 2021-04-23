<?php

namespace Process\Admin\Label;

class Up extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'label_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\Label',
            'method' => 'get',
            'selector' => 'label_id'
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
            UPDATE ' . TABLE_LABELS . '
            LEFT JOIN ' . TABLE_LABELS . '2 ON l2.position_index = l.position_index + 1
            SET l.position_index = l.position_index + 1,
                l2.position_index = l2.position_index - 1
            WHERE l.label_id = ? AND l2.label_id IS NOT NULL
        ', [$this->data->get('label_id')]);
    
        // ADD RECORD TO LOG
        $this->log();
    }
}