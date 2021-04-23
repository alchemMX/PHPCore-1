<?php

namespace Process\Verify;

class Verify extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'user_id',
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'login' => REQUIRE_LOGOUT
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('DELETE v FROM ' . TABLE_VERIFY . ' WHERE user_id = ?', [$this->data->get('user_id')]);
    }
}