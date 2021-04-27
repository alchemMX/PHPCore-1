<?php

namespace Block\Admin;

/**
 * Post
 */
class Post extends \Block\Post
{    
    /**
     * Returns post 
     *
     * @param  int $postID Post ID
     * 
     * @return array
     */
    public function get( int $postID )
    {
        return $this->db->query('
            SELECT p.*, t.topic_id, t.topic_url, t.topic_name, t.topic_posts, 1 AS post_permission,
                (SELECT COUNT(*) FROM ' . TABLE_POSTS . '2 WHERE p2.post_id <= p.post_id AND p2.topic_id = p.topic_id) AS position,
               t.deleted_id AS topic_deleted_id, p.deleted_id AS post_deleted_id
            FROM ' . TABLE_POSTS . ' 
            LEFT JOIN ' . TABLE_TOPICS . ' ON t.topic_id = p.topic_id
            WHERE p.post_id = ?
    ', [$postID]);
    }

    /**
     * Returns posts from topic
     *
     * @param  int $topicID Topic id
     * 
     * @return array
     */
    public function getParent( int $topicID )
    {
        return $this->db->query('
            SELECT r.report_id, r.report_status, p.*, t.topic_name, user_last_activity, ' . $this->select->user() . ', user_signature, user_posts, user_topics, group_name, user_reputation,
                CASE WHEN pl.post_id IS NULL THEN 0 ELSE 1 END AS is_like, t.topic_name, t.deleted_id AS topic_deleted_id, p.deleted_id AS post_deleted_id,
                CASE WHEN ( SELECT COUNT(*) FROM ' . TABLE_POSTS_LIKES . ' WHERE post_id = p.post_id ) > 5 THEN 1 ELSE 0 END AS is_more_likes,
                ( SELECT COUNT(*) FROM ' . TABLE_POSTS_LIKES . ' WHERE post_id = p.post_id ) AS count_of_likes
            FROM ' . TABLE_POSTS . '
            LEFT JOIN ' . TABLE_TOPICS . ' ON t.topic_id = p.topic_id
            ' . $this->join->user('p.user_id'). '
            LEFT JOIN ' . TABLE_POSTS_LIKES . ' ON pl.post_id = p.post_id
            LEFT JOIN ' . TABLE_REPORTS . ' ON r.report_id = p.report_id
            WHERE p.topic_id = ?
            GROUP BY p.post_id 
            ORDER BY post_created ASC 
            LIMIT ?, ?
        ', [$topicID, $this->pagination['offset'], $this->pagination['max']], ROWS);
    }

    /**
     * Returns count of posts in topic
     *
     * @param  int $topicID Topic ID
     * 
     * @return int
     */
    public function getParentCount( int $topicID )
    {
        return (int)$this->db->query('
            SELECT COUNT(*) AS count
            FROM ' . TABLE_POSTS . '
            WHERE topic_id = ?
        ', [$topicID])['count'];
    }
}