<?php

namespace Process\Admin\User;

/**
 * Search
 */
class Search extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
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
    public array $options = [
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