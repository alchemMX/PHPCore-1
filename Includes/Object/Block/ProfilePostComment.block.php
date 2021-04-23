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
     * @param int $ID
     * 
     * @return array
     */
    public function get( int $ID )
    {
        return $this->db->query('
            SELECT ppc.*, pp.profile_id, u.user_name, u.user_id AS profile_user_id, u.user_name AS profile_user_name,
                (SELECT COUNT(*) FROM ' . TABLE_PROFILE_POSTS . ' WHERE pp.profile_post_id >= ppc.profile_post_id AND pp.profile_id = ppc.profile_id AND pp.deleted_id IS NULL) AS position
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = ppc.profile_id
            LEFT JOIN ' . TABLE_PROFILE_POSTS . ' ON pp.profile_post_id = ppc.profile_post_id
            WHERE profile_post_comment_id = ? AND ppc.deleted_id IS NULL AND pp.deleted_id IS NULL
        ', [$ID]);
    }

    /**
     * Returns profile post comment. This method is for user notifications.
     *
     * @param  int $ID
     * 
     * @return array
     */
    public function getUN( int $ID )
    {
        return $this->db->query('
            SELECT ppc.profile_post_comment_id, pp.profile_post_id, u.user_name, u.user_id, (SELECT COUNT(*) FROM ' . TABLE_PROFILE_POSTS . ' WHERE pp.profile_post_id >= ppc.profile_post_id AND pp.profile_id = ppc.profile_id AND pp.deleted_id IS NULL) AS position
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = ppc.profile_id
            LEFT JOIN ' . TABLE_PROFILE_POSTS . ' ON pp.profile_post_id = ppc.profile_post_id
            WHERE profile_post_comment_id = ?
        ', [$ID]);
    }

    /**
     * Returns profile post comment from profile post
     * 
     * @param int $profilePostID
     * @param int $number Number of profile post comments
     * 
     * @return array
     */
    public function getParent( int $profilePostID, int $number = 5 )
    {
        return array_reverse($this->db->query('
            SELECT ppc.*, ' . $this->select->user() . ', user_last_activity
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            ' . $this->join->user('ppc.user_id'). '
            WHERE profile_post_id = ? AND ppc.deleted_id IS NULL
            GROUP BY ppc.profile_post_comment_id
            ORDER BY profile_post_comment_time DESC
            LIMIT ?
        ', [$profilePostID, $number], ROWS));
    }

    /**
     * Returns all another profile comments after $number recent comment
     * 
     * @param int $profilePostID
     * @param int $number
     * 
     * @return array
     */
    public function getAfterNext( int $profilePostID, int $number = 5 )
    {
        return array_reverse($this->db->query('
            SELECT ppc.*, ' . $this->select->user() . ', user_last_activity
            FROM ' . TABLE_PROFILE_POSTS_COMMENTS . '
            ' . $this->join->user('ppc.user_id'). '
            WHERE profile_post_id = ? AND ppc.deleted_id IS NULL
            GROUP BY ppc.profile_post_comment_id
            ORDER BY profile_post_comment_time DESC
            LIMIT ?, 18446744073709551615
        ', [$profilePostID, $number], ROWS));
    }
}