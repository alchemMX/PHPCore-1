<?php

namespace Process\Admin\Report;

class Close extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'report_id',
            'report_type',
            'report_type_id'
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

        switch ($this->data->get('report_type')) {

            case 'Post':
                $this->db->query('UPDATE ' . TABLE_POSTS . ' SET report_id = NULL WHERE post_id = ?', [$this->data->get('report_type_id')]);
            break;

            case 'Topic':
                $this->db->query('UPDATE ' . TABLE_TOPICS . ' SET report_id = NULL WHERE topic_id = ?', [$this->data->get('report_type_id')]);
            break;

            case 'ProfilePost':
                $this->db->query('UPDATE ' . TABLE_PROFILE_POSTS . ' SET report_id = NULL WHERE profile_post_id = ?', [$this->data->get('report_type_id')]);
            break;

            case 'ProfilePostComment':
                $this->db->query('UPDATE ' . TABLE_PROFILE_POSTS_COMMENTS . ' SET report_id = NULL WHERE profile_post_comment_id = ?', [$this->data->get('report_type_id')]);
            break;

        }

        // ADD RECORD TO LOG
        $this->log();

        $this->redirectTo('/admin/report/');
    }
}