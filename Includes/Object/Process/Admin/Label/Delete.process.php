<?php

namespace Process\Admin\Label;

class Delete extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'label_id'
        ],
        'block' => [
            'label_name'
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
            LEFT JOIN ' . TABLE_LABELS . '2 ON l2.position_index > l.position_index
            SET l2.position_index = l2.position_index - 1
            WHERE l.label_id = ?
        ', [$this->data->get('label_id')]);

        $this->db->query('
            DELETE l, tlb
            FROM ' . TABLE_LABELS . '
            LEFT JOIN ' . TABLE_TOPICS_LABELS . ' ON tlb.label_id = l.label_id
            WHERE l.label_id = ?',
            [$this->data->get('label_id')]
        );

        // ADD RECORD TO LOG
        $this->log($this->data->get('label_name'));
    }
}