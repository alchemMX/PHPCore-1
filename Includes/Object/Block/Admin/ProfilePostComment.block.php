<?php

namespace Block\Admin;

/**
 * ProfilePostComment
 */
class ProfilePostComment extends \Block\ProfilePostComment
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
            SELECT ppc.user_id, profile_post_comment_id, ppc.profile_id, u.user_name, u.user_id AS profile_user_id, u.user_name AS profile_user_name,
                pp.deleted_id AS profile_post_deleted_id, ppc.deleted_id AS profile_post_comment_deleted_id,
                (SELECT COUNT(*) FROM ' . TABLE_PROFILE_POSTS . ' WHERE pp.profile_post_id >= ppc.profile_post_id AND pp.profile_id = ppc.profile_id) AS position
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            LEFT JOIN ' . TABLE_PROFILE_POSTS . ' ON pp.profile_post_id = ppc.profile_post_id
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = ppc.profile_id
            WHERE profile_post_comment_id = ?
        ', [$profilePostCommentID]);
    }

    /**
     * Returns profile post comments from profile post
     * 
     * @param int $profilePostID Profile post ID
     * @param int $number Number of profile post comments
     * 
     * @return array
     */
    public function getParent( int $profilePostID, int $number = 5)
    {
        return array_reverse($this->db->query('
            SELECT r.report_id, r.report_status, ppc.*, ' . $this->select->user() . ', user_last_activity
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            ' . $this->join->user('ppc.user_id'). '
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = ppc.report_id AND r.report_status = 0
            WHERE profile_post_id = ?
            GROUP BY ppc.profile_post_comment_id
            ORDER BY profile_post_comment_time DESC
            LIMIT ?
        ', [$profilePostID, $number], ROWS));
    }

    /**
     * Returns all another profile comments after $number recent comment
     * 
     * @param int $profilePostID Profile post ID
     * @param int $number Number of profile post comments
     * 
     * @return array
     */
    public function getAfterNext( int $profilePostID, int $number = 5 )
    {
        return array_reverse($this->db->query('
            SELECT ppc.*, ' . $this->select->user() . ', user_last_activity
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            ' . $this->join->user('ppc.user_id'). '
            WHERE profile_post_id = ?
            GROUP BY ppc.profile_post_comment_id
            ORDER BY profile_post_comment_time DESC
            LIMIT ?, 18446744073709551615
        ', [$profilePostID, $number], ROWS));
    }
}