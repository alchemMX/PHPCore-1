<?php

namespace Process\Admin\Report;

/**
 * Close
 */
class Close extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'report_id',
            'report_type',
            'report_type_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->db->query('
            UPDATE ' . TABLE_REPORTS . '
            SET report_status = 1
            WHERE report_id = ?
        ', [$this->data->get('report_id')]);

        $this->db->insert(TABLE_REPORTS_REASONS, [
            'user_id' => LOGGED_USER_ID,
            'report_id' => $this->data->get('report_id'),
            'reason_type' => (int)2
        ]);

        // ADD RECORD TO LOG
        $this->log();

        $this->redirectTo('/admin/report/');
    }
}