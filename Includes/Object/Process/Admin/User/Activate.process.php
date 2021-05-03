<?php

namespace Process\Admin\User;

/**
 * Activate
 */
class Activate extends \Process\ProcessExtend
{
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'user_id'
        ],
        'block' => [
            'user_name'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
        'verify' => [
            'block' => '\Block\User',
            'method' => 'get',
            'selector' => 'user_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('DELETE v FROM ' . TABLE_VERIFY . ' WHERE user_id = ?', [$this->data->get('user_id')]);

        // ADD RECORD TO LOG
        $this->log($this->data->get('user_name'));
    }
}