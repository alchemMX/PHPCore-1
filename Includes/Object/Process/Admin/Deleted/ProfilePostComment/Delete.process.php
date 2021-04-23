<?php

namespace Process\Admin\Deleted\ProfilePostComment;

class Delete extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'deleted_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [
        'verify' => [
            'block' => '\Block\Deleted',
            'method' => 'get',
            'selector' => 'deleted_id'
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
            DELETE dc, ppc, r, rr
            FROM ' . TABLE_DELETED_CONTENT. ' 
            LEFT JOIN ' . TABLE_PROFILE_POSTS_COMMENTS . ' ON ppc.profile_post_comment_id = dc.deleted_type_id
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = ppc.report_id
            LEFT JOIN ' . TABLE_REPORTS_REASONS . ' ON rr.report_id = r.report_id
            WHERE dc.deleted_id = ?
        ', [$this->data->get('deleted_id')]);
        
        $this->system->stats->set('profile_post_comment_deleted', +1);

        // ADD RECORD TO LOG
        $this->log();

        $this->redirectTo('/admin/deleted/');
    }
}