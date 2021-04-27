<?php

namespace Process\Verify;

class Verify extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'user_id',
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
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