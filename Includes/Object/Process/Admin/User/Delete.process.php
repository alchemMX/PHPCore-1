<?php

namespace Process\Admin\User;

use Model\File;

class Delete extends \Process\ProcessExtend
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
        $this->db->query('
            UPDATE ' . TABLE_USERS . '
            SET is_deleted = 1,
                user_profile_image = "",
                user_header_image = "",
                user_reputation = 0,
                user_signature = "",
                user_password = "",
                user_location = "",
                user_gender = "",
                user_topics = 0,
                user_posts = 0,
                user_email = "",
                user_text = "",
                user_name = "",
                user_hash = "",
                group_id = ?,
                user_age = 0
            WHERE user_id = ?
        ', [$this->system->settings->get('default_group'), $this->data->get('user_id')]);

        $this->db->query('
            DELETE pl, tl, unr, un, pp, dc, r, ppc, dc2, r2, fp, v, cr
            FROM ' . TABLE_USERS . '
            LEFT JOIN ' . TABLE_POSTS_LIKES . ' ON pl.user_id = u.user_id
            LEFT JOIN ' . TABLE_TOPICS_LIKES . ' ON tl.user_id = u.user_id
            LEFT JOIN ' . TABLE_USERS_UNREAD . ' ON unr.user_id = u.user_id
            LEFT JOIN ' . TABLE_USERS_NOTIFICATIONS . ' ON to_user_id = u.user_id
            LEFT JOIN ' . TABLE_PROFILE_POSTS . ' ON pp.profile_id = u.user_id
            LEFT JOIN ' . TABLE_DELETED_CONTENT . ' ON dc.deleted_id = pp.deleted_id
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = pp.report_id
            LEFT JOIN ' . TABLE_PROFILE_POSTS_COMMENTS . ' ON ppc.profile_post_id = pp.profile_post_id
            LEFT JOIN ' . TABLE_DELETED_CONTENT . '2 ON dc.deleted_id = ppc.deleted_id
            LEFT JOIN ' . TABLE_REPORTS . '2 ON r.report_id = ppc.report_id
            LEFT JOIN ' . TABLE_FORGOT . ' ON fp.user_id = u.user_id
            LEFT JOIN ' . TABLE_VERIFY . ' ON v.user_id = u.user_id
            LEFT JOIN ' . TABLE_CONVERSATIONS_RECIPIENTS . ' ON cr.user_id = u.user_id
            WHERE u.user_id = ?
        ', [$this->data->get('user_id')]);

        $file = new File();
        $file->deleteImage('/profiles/' . $this->data->get('user_id'));
        $file->deleteImage('/headers/' . $this->data->get('user_id'));

        $this->system->stats->set('user_deleted', +1);

        // ADD RECORD TO LOG
        $this->log($this->data->get('user_name'));

        $this->redirectTo('/admin/user/');
    }
}