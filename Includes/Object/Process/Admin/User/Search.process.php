<?php

namespace Process\Admin\User;

class Search extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'form' => [
            'user_name' => [
                'type' => 'text',
                'required' => true
            ]
        ],
        'block' => [
            'user_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\User',
            'method' => 'getByName',
            'selector' => 'user_name'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->redirectTo('/admin/user/show/' . $this->data->get('user_id'));
    }
}