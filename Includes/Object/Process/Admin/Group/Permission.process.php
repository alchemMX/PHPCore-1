<?php

namespace Process\Admin\Group;

class Permission extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'group_permission'  => [
                'type' => 'array'
            ]
        ],
        'data' => [
            'group_id',
            'group_name'
        ],
        'block' => [
            'group_name'
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
        $this->db->update(TABLE_GROUPS, [
            'group_permission'  => implode(',', $this->data->get('group_permission'))
        ], $this->data->get('group_id'));

        // ADD RECORD TO LOG
        $this->log($this->data->get('group_name'));
    }
}