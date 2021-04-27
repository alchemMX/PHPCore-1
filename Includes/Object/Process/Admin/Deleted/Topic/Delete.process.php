<?php

namespace Process\Admin\Deleted\Topic;

class Delete extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'deleted_id'
        ],
        'block' => [
            'deleted_type_user_id'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
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
        $posts = (int)$this->db->query('
            SELECT COUNT(*) as count
            FROM ' . TABLE_POSTS . '
            LEFT JOIN ' . TABLE_TOPICS . ' ON t.topic_id = p.topic_id
            LEFT JOIN ' . TABLE_DELETED_CONTENT . ' ON dc.deleted_id = t.deleted_id
            WHERE dc.deleted_id = ?
        ', [$this->data->get('deleted_id')])['count'] ?? 0;

        $this->db->query('
            DELETE dc, t, tl, tlb, r, rr, p, pl, r2, rr2, dc2
            FROM ' . TABLE_DELETED_CONTENT . '
            LEFT JOIN ' . TABLE_TOPICS. ' ON t.topic_id = dc.deleted_type_id
            LEFT JOIN ' . TABLE_TOPICS_LIKES . ' ON tl.topic_id = t.topic_id 
            LEFT JOIN ' . TABLE_TOPICS_LABELS . ' ON tlb.topic_id = t.topic_id 
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = t.report_id
            LEFT JOIN ' . TABLE_REPORTS_REASONS . ' ON rr.report_id = r.report_id

            LEFT JOIN ' . TABLE_POSTS . ' ON p.topic_id = t.topic_id 
            LEFT JOIN ' . TABLE_POSTS_LIKES . ' ON pl.post_id = p.post_id
            LEFT JOIN ' . TABLE_REPORTS . '2 ON r2.report_id = p.report_id
            LEFT JOIN ' . TABLE_REPORTS_REASONS . '2 ON rr2.report_id = r2.report_id
            LEFT JOIN ' . TABLE_DELETED_CONTENT . '2 ON dc2.deleted_id = p.deleted_id
            WHERE dc.deleted_id = ?
        ', [$this->data->get('deleted_id')]);

        $this->system->stats->set('topic_deleted', +1);
        $this->system->stats->set('post_deleted', +($posts));

        // ADD RECORD TO LOG
        $this->log();

        $this->redirectTo('/admin/deleted/');
    }
}