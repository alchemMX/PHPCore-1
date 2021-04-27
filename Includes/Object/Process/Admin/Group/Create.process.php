<?php

namespace Process\Admin\Group;

class Create extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'group_name'        => [
                'type' => 'text',
                'required' => true
            ]
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('
            UPDATE ' . TABLE_GROUPS . '
            SET group_index = group_index + 1
        ');

        $this->db->insert(TABLE_GROUPS, [
            'group_name'        => $this->data->get('group_name'),
            'group_color'       => '#555555',
            'group_index'       => 1,
            'group_class_name'  => parse($this->data->get('group_name')),
            'group_permission'  => ''
        ]);

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