<?php

namespace Process\Admin\Group;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'group_name'        => [
                'type' => 'text',
                'required' => true
            ],
            'group_color'       => [
                'type' => 'text',
                'required' => true
            ],
            'is_default'        => [
                'type' => 'checkbox'
            ],
            'group_permission'  => [
                'type' => 'array'
            ]
        ],
        'data' => [
            'group_id'
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
        if ($this->data->is('is_default')) {                
            $this->system->settings->set('default_group', $this->data->get('group_id'));
        }

        $this->db->update(TABLE_GROUPS, [
            'group_name'        => $this->data->get('group_name'),
            'group_color'       => $this->data->get('group_color'),
            'group_class_name'  => parse($this->data->get('group_name')),
            'group_permission'  => implode(',', $this->data->get('group_permission'))
        ], $this->data->get('group_id'));

        $css = '';
        foreach ($this->db->query('SELECT group_class_name, group_color FROM ' . TABLE_GROUPS, [], ROWS) as $group) {
            $css .= '.username.user--' . $group['group_class_name'] . '{color:' . $group['group_color'] . '}.statue.statue--' . $group['group_class_name'] . '{background-color:' . $group['group_color'] . '}.group--' . $group['group_class_name'] . ' input[type="checkbox"] + label span{border-color:' . $group['group_color'] . '}.group--' . $group['group_class_name'] . ' input[type="checkbox"]:checked + label span{background-color:' . $group['group_color'] . '}';
        }
        file_put_contents(ROOT . '/Includes/Template/css/Group.min.css', $css);

        // ADD RECORD TO LOG
        $this->log($this->data->get('group_name'));

        $this->updateSession();
    }
}