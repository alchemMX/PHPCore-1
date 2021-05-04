<?php

namespace Process\Admin\Deleted\ProfilePost;

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
            LEFT JOIN ' . TABLE_PROFILE_POSTS . ' ON pp.profile_post_id = dc.deleted_type_id
            SET pp.deleted_id = NULL
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