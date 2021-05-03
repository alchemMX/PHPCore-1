<?php

namespace Process\Admin\Deleted\Topic;

/**
 * Back
 */
class Back extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'deleted_id'
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
        $this->db->query('
            UPDATE ' . TABLE_DELETED_CONTENT . '
            LEFT JOIN ' . TABLE_TOPICS . ' ON t.topic_id = dc.deleted_type_id
            LEFT JOIN ' . TABLE_FORUMS . ' ON f.forum_id = t.forum_id
            SET t.deleted_id = NULL, f.forum_topics = f.forum_topics + 1, f.forum_posts = f.forum_posts + t.topic_posts
            WHERE dc.deleted_id = ?
        ', [$this->data->get('deleted_id')]);

        $this->db->query('
            DELETE dc FROM ' . TABLE_DELETED_CONTENT . '
            WHERE deleted_id = ?
        ', [$this->data->get('deleted_id')]);
        
        // ADD RECORD TO LOG
        $this->log();

        $this->redirectTo('/admin/deleted/');
    }
}