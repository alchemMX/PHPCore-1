<?php

namespace Process\Admin\Menu\ButtonSub;

/**
 * Down
 */
class Down extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'button_sub_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
        'verify' => [
            'block' => '\Block\ButtonSub',
            'method' => 'get',
            'selector' => 'button_sub_id'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('
            UPDATE ' . TABLE_BUTTONS_SUB . '
            LEFT JOIN ' . TABLE_BUTTONS_SUB . '2 ON bs2.position_index = bs.position_index - 1 AND bs2.button_id = bs.button_id
            SET bs.position_index = bs.position_index - 1,
                bs2.position_index = bs2.position_index + 1
            WHERE bs.button_sub_id = ? AND bs2.button_sub_id IS NOT NULL
        ', [$this->data->get('button_sub_id')]);

        // ADD RECORD TO LOG
        $this->log();
    }
}