<?php

namespace Process\Admin\Menu\Dropdown;

class Create extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'button_name' => [
                'type' => 'text',
                'required' => true
            ],
            'button_icon' => [
                'type' => 'text'
            ],
            'button_icon_style' => [
                'custom'  => ['fas', 'far', 'fab']
            ]
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        // UPDATE POSITION INDEX
        $this->db->update(TABLE_BUTTONS, ['position_index' => [PLUS]]);

        // ADDS BUTTON
        $this->db->insert(TABLE_BUTTONS, [
            'button_name'       => $this->data->get('button_name'),
            'is_dropdown'       => '1',
            'button_icon'       => $this->data->get('button_icon'),
            'button_icon_style' => $this->data->get('button_icon_style')
        ]);

        // ADD RECORD TO LOG
        $this->log($this->data->get('button_name'));
    }
}