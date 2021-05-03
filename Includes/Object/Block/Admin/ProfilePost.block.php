<?php

namespace Block\Admin;

/**
 * ProfilePost
 */
class ProfilePost extends \Block\ProfilePost
{
    /**
     * Returns profile post
     * 
     * @param int $profilePostID Profile post ID
     * 
     * @return array
     */
    public function get( int $profilePostID )
    {
        return $this->db->query('
            SELECT pp.user_id, profile_post_id, u.user_name, profile_id, u.user_id AS profile_user_id, u.user_name AS profile_user_name,
                (SELECT COUNT(*) FROM ' . TABLE_PROFILE_POSTS . '2 WHERE pp2.profile_post_id >= pp.profile_post_id AND pp2.profile_id = pp.profile_id) AS position,
                pp.deleted_id as profile_post_deleted_id
            FROM ' . TABLE_PROFILE_POSTS . '
            LEFT JOIN ' . TABLE_USERS . ' ON u.user_id = pp.profile_id
            WHERE profile_post_id = ?
        ', [$profilePostID]);
    }

    /**
     * Returns profile posts from profile
     * 
     * @param int $profileID Profile ID
     * 
     * @return array
     */
    public function getParent( int $profileID )
    {
        return $this->db->query('
            SELECT r.report_id, r.report_status, pp.*, ' . $this->select->user() . ', user_last_activity,
            CASE WHEN ( SELECT COUNT(*) FROM ' . TABLE_PROFILE_POSTS_COMMENTS . ' WHERE profile_post_id = pp.profile_post_id ) > 5 THEN 1 ELSE 0 END AS next
            FROM ' . TABLE_PROFILE_POSTS . '
            ' . $this->join->user('pp.user_id'). '
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = pp.report_id
            WHERE profile_id = ?
            ORDER BY profile_post_created DESC
            LIMIT ?, ?
        ', [$profileID, $this->pagination['offset'], $this->pagination['max']], ROWS);

    }

    /**
     * Returns count of profile posts from profile
     *
     * @param  int $profileID ProfileID Profile ID
     * 
     * @return int
     */
    public function getParentCount( int $profileID )
    {
        return (int)$this->db->query('
            SELECT COUNT(*) AS count
            FROM ' . TABLE_PROFILE_POSTS . '
            WHERE profile_id = ?
        ', [$profileID])['count'];
    } 
}