<?php

namespace Block;

/**
 * Chart
 */
class Chart extends Block
{
    /**
     * Returns month data for chart
     * 
     * @return array
     */
    public function getMonth()
    {
        return $this->db->query('
            SELECT SUM(users) as users, SUM(posts) as posts, SUM(topics) as topics, date, month
            FROM (
                SELECT COUNT(*) users, 0 topics, 0 posts, DATE_FORMAT(user_registered, "%Y-%m-%d") date, DATE_FORMAT(user_registered, "%Y-%m") month
                FROM ' . TABLE_USERS . ' 
                WHERE u.is_deleted = 0
                GROUP BY DATE_FORMAT(user_registered, "%Y-%m") 
                UNION ALL
                SELECT 0 users, COUNT(*) topics, 0 posts, DATE_FORMAT(topic_created, "%Y-%m-%d") date, DATE_FORMAT(topic_created, "%Y-%m") month
                FROM ' . TABLE_TOPICS . ' 
                GROUP BY DATE_FORMAT(topic_created, "%Y-%m") 
                UNION ALL
                SELECT 0 users, 0 topics, COUNT(*) posts, DATE_FORMAT(post_created, "%Y-%m-%d") date, DATE_FORMAT(post_created, "%Y-%m") month
                FROM ' . TABLE_POSTS . '
                GROUP BY DATE_FORMAT(post_created, "%Y-%m") 
            ) as A
            WHERE date BETWEEN DATE_SUB(NOW(), INTERVAL 1 YEAR) AND NOW()
            GROUP BY month
        ', [], ROWS);
    }

    /**
     * Returns day data
     * 
     * @return array
     */
    public function getDay()
    {
        return $this->db->query('
            SELECT SUM(users) as users, SUM(posts) as posts, SUM(topics) as topics, day
            FROM (
                SELECT COUNT(*) users, 0 topics, 0 posts, DATE_FORMAT(user_registered, "%Y-%m-%d") day
                FROM ' . TABLE_USERS . ' 
                WHERE u.is_deleted = 0
                GROUP BY DATE_FORMAT(user_registered, "%Y-%m-%d") 
                UNION ALL
                SELECT 0 users, COUNT(*) topics, 0 posts, DATE_FORMAT(topic_created, "%Y-%m-%d")  day
                FROM ' . TABLE_TOPICS . ' 
                GROUP BY DATE_FORMAT(topic_created, "%Y-%m-%d") 
                UNION ALL
                SELECT 0 users, 0 topics, COUNT(*) posts, DATE_FORMAT(post_created, "%Y-%m-%d")  day
                FROM ' . TABLE_POSTS . ' 
                GROUP BY DATE_FORMAT(post_created, "%Y-%m-%d") 
            ) as A
            WHERE day BETWEEN DATE_SUB(NOW(), INTERVAL 30 DAY) AND NOW()
            GROUP BY day
        ',[], ROWS);
    }
}