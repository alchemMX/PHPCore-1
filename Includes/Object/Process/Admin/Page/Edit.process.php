<?php

namespace Process\Admin\Page;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'page_name' => [
                'type' => 'text',
                'required' => true
            ],
            'page_css'  => [
                'type' => 'text'
            ],
            'page_html' => [
                'type' => 'text'
            ]
        ],
        'data' => [
            'page_id'
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
        @file_put_contents(ROOT . '/Pages/' . $this->data->get('page_id') . '/html.html', $this->data->get('page_html'));
        @file_put_contents(ROOT . '/Pages/' . $this->data->get('page_id') . '/css.css', $this->data->get('page_css'));

        // EDIT PAGE
        $this->db->update(TABLE_PAGES, [
            'page_url' => parse($this->data->get('page_name')),
            'page_name' => $this->data->get('page_name')
        ], $this->data->get('page_id'));

        // ADD RECORD TO LOG
        $this->log($this->data->get('page_name'));
    }
}