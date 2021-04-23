<?php

namespace Process\Admin\Menu\Button;

class Delete extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'button_id'
        ],
        'block' => [
            'button_name'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\Button',
            'method' => 'get',
            'selector' => 'button_id'
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
            UPDATE ' . TABLE_BUTTONS . '
            LEFT JOIN ' . TABLE_BUTTONS . '2 ON b2.position_index > b.position_index
            SET b2.position_index = b2.position_index - 1
            WHERE b.button_id = ?
        ', [$this->data->get('button_id')]);

        $this->db->query('DELETE b, bs FROM ' . TABLE_BUTTONS . ' LEFT JOIN ' . TABLE_BUTTONS_SUB . ' ON bs.button_id = b.button_id WHERE b.button_id = ?', [$this->data->get('button_id')]);
    
        // ADD RECORD TO LOG
        $this->log($this->data->get('button_name'));
    }
}