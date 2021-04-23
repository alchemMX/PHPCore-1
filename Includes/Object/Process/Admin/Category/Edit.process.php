<?php

namespace Process\Admin\Category;

use Block\Group;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'category_name'         => [
                'type' => 'text',
                'required' => true
            ],
            'category_description'  => [
                'type' => 'text',
                'required' => true
            ],
            'see_groups'            => [
                'type' => 'array',
                'block' => '\Block\Group.getAllIDWithVisitor'
            ]
        ],
        'data' => [
            'category_id'
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
        // UPDATE CATEGORY
        $this->db->update(TABLE_CATEGORIES, [
            'category_name'         => $this->data->get('category_name'),
            'category_description'  => $this->data->get('category_description')
        ], $this->data->get('category_id'));

        // ADD RECORD TO LOG
        $this->log($this->data->get('category_name'));
    }
}