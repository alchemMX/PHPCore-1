<?php

namespace Block;

/**
 * ProfilePostComment
 */
class ProfilePostComment extends Block
{
    /**
     * Returns profile post comment
     * 
     * @param int $profilePostCommentID Profile post comment ID
     * 
     * @return array
     */
    public function get( int $profilePostCommentID )
    {
        return $this->db->query('
            SELECT ppc.*, pp.profile_id, u.user_name, u.user_id AS profile_user_id, u.user_name AS profile_user_name,
                (SELECT COUNT(*) FROM ' . TABLE_PROFILE_POSTS . '2 WHERE pp2.profile_post_id >= ppc.profile_post_id AND pp2.profile_id = pp.profile_id AND pp2.deleted_id IS NULL) AS position
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            LEFT JOIN ' . TABLE_PROFILE_POSTS . ' ON pp.profile_post_id = ppc.profile_post_id
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = pp.profile_id
            WHERE profile_post_comment_id = ? AND ppc.deleted_id IS NULL AND pp.deleted_id IS NULL
        ', [$profilePostCommentID]);
    }

    /**
     * Returns profile post comment. This method is for user notifications.
     *
     * @param  int $profilePostCommentID Profile post comment ID
     * 
     * @return array
     */
    public function getUN( int $profilePostCommentID )
    {
        return $this->db->query('
            SELECT ppc.profile_post_comment_id, pp.profile_post_id, u.user_name, u.user_id, (SELECT COUNT(*) FROM ' . TABLE_PROFILE_POSTS . '2 WHERE pp2.profile_post_id >= ppc.profile_post_id AND pp2.profile_id = pp.profile_id AND pp2.deleted_id IS NULL) AS position
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            LEFT JOIN ' . TABLE_PROFILE_POSTS . ' ON pp.profile_post_id = ppc.profile_post_id
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = pp.profile_id
            WHERE profile_post_comment_id = ?
        ', [$profilePostCommentID]);
    }

    /**
     * Returns profile post comment from profile post
     * 
     * @param int $profilePostID Profile post ID
     * @param int $number Number of profile post comments
     * 
     * @return array
     */
    public function getParent( int $profilePostID, int $number = 5 )
    {
        return array_reverse($this->db->query('
            SELECT ppc.*, r.report_status, ' . $this->select->user() . ', user_last_activity
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            ' . $this->join->user('ppc.user_id'). '
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = ppc.report_id
            WHERE profile_post_id = ? AND ppc.deleted_id IS NULL
            GROUP BY ppc.profile_post_comment_id
            ORDER BY profile_post_comment_created DESC
            LIMIT ?
        ', [$profilePostID, $number], ROWS));
    }

    /**
     * Returns all another profile post comments after $number recent comment
     * 
     * @param int $profilePostID Profile post ID
     * @param int $number Number after which profile post comments will be returned
     * 
     * @return array
     */
    public function getAfterNext( int $profilePostID, int $number = 5 )
    {
        return array_reverse($this->db->query('
            SELECT ppc.*, r.report_status, ' . $this->select->user() . ', user_last_activity
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            ' . $this->join->user('ppc.user_id'). '
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = ppc.report_id
            WHERE profile_post_id = ? AND ppc.deleted_id IS NULL
            GROUP BY ppc.profile_post_comment_id
            ORDER BY profile_post_comment_created DESC
            LIMIT ?, 18446744073709551615
        ', [$profilePostID, $number], ROWS));
    }
}