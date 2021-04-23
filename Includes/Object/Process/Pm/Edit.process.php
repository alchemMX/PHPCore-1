<?php

namespace Process\Pm;

class Edit extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'pm_subject'    => [
                'type' => 'text',
                'required' => true,
                'length_max' => 50
            ],
            'pm_text'       => [
                'type' => 'html',
                'required' => true,
                'length_max' => 10000
            ],
        ],
        'data' => [
            'pm_id'
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
        $this->db->update(TABLE_PRIVATE_MESSAGES, [
            'pm_url'        => parse($this->data->get('pm_subject')),
            'pm_text' 		=> $this->data->get('pm_text'),
            'is_edited'     => '1',
            'pm_edited'     => DATE_DATABASE,
            'pm_subject' 	=> $this->data->get('pm_subject'),
        ], $this->data->get('pm_id'));
    }
}