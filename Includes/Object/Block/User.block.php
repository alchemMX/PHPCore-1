<?php

namespace Block;

/**
 * User
 */
class User extends Block
{
    /**
     * Returns user by user id
     *
     * @param  int $userID User ID
     * 
     * @return array
     */
    public function get( int $userID )
    {
        return $this->db->query('
            SELECT u.*, g.group_name, g.group_class_name, g.group_index, fp.forgot_code, v.verify_code
            FROM ' . TABLE_USERS . '
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            LEFT JOIN ' . TABLE_FORGOT . ' ON fp.user_id = u.user_id
            LEFT JOIN ' . TABLE_VERIFY . ' ON v.user_id = u.user_id
            WHERE u.user_id = ? AND is_deleted = 0
        ', [$userID]);
    }

    /**
     * Returns user by user name
     *
     * @param  string $name User name
     * 
     * @return array
     */
    public function getByName( string $userName )
    {
        return $this->db->query('
            SELECT u.*, g.group_name, g.group_class_name, g.group_index, fp.forgot_code, v.verify_code
            FROM ' . TABLE_USERS . '
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            LEFT JOIN ' . TABLE_FORGOT . ' ON fp.user_id = u.user_id
            LEFT JOIN ' . TABLE_VERIFY . ' ON v.user_id = u.user_id
            WHERE u.user_name = ?
        ', [$userName]);
    }

    /**
     * Returns user by email
     *
     * @param  string $userEmail User emial
     * 
     * @return array
     */
    public function getByEmail( string $userEmail )
    {
        return $this->db->query('
            SELECT u.*, g.group_name, g.group_class_name, g.group_index, fp.forgot_code
            FROM ' . TABLE_USERS . '
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            LEFT JOIN ' . TABLE_FORGOT . ' ON fp.user_id = u.user_id
            WHERE u.user_email = ?
        ', [$userEmail]);
    }

    /**
     * Returns user by user hash
     *
     * @param  string $userHash User hash
     * 
     * @return array
     */
    public function getByHash( string $userHash )
    {
        return $this->db->query('
            SELECT u.*, g.group_name, g.group_class_name, g.group_index, g.group_permission
            FROM ' . TABLE_USERS . '
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            WHERE user_hash = ?
        ', [$userHash]) ?: [];
    }

    /**
     * Returns users unread private messages
     *
     * @param  int $userID User ID
     * 
     * @return array
     */
    public function getUnread( int $userID )
    {
        return array_column($this->db->query('
            SELECT conversation_id
            FROM ' . TABLE_USERS_UNREAD . '
            WHERE user_id = ?
        ', [$userID], ROWS), 'conversation_id');
    }
    
    /**
     * Returns all users
     *
     * @return array
     */
    public function getAll()
    {
        return $this->db->query('
            SELECT ' . $this->select->user() . ', is_admin, group_name, group_index, user_reputation, user_registered
            FROM ' . TABLE_USERS . '
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            WHERE is_deleted = 0
            ORDER BY is_admin DESC, group_index DESC, user_registered ASC
            LIMIT ?, ?
        ', [$this->pagination['offset'], $this->pagination['max']], ROWS);
    }

    /**
     * Returns count of users
     * 
     * @return int
     */
    public function getAllCount()
    {
        return (int)$this->db->query('SELECT COUNT(*) as count FROM ' . TABLE_USERS . ' WHERE is_deleted = 0')['count'];
    }

    /**
     * Returns online users
     *
     * @return array
     */
    public function getOnline()
    {
        return $this->db->query('
            SELECT ' . $this->select->user() . '
            FROM ' . TABLE_USERS. '
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id 
            WHERE user_last_activity > DATE_SUB(NOW(), INTERVAL 1 MINUTE) AND is_deleted = 0
        ', [], ROWS);
    }

    /**
     * Returns count of recent registered users
     *
     * @return int
     */
    public function getRecentCount()
    {
        return $this->db->query('
            SELECT COUNT(*) AS count
            FROM ' . TABLE_USERS . '
            WHERE user_registered > DATE_SUB(CURDATE(), INTERVAL 1 HOUR) AND is_deleted = 0
        ')['count'];
    }

    /**
     * Returns last registered users
     *
     * @param int $number Number of users
     * 
     * @return array
     */
    public function getRecent( int $number = 5 )
    {
        return $this->db->query('
            SELECT ' . $this->select->user() . ', u.is_admin, u.user_registered, g.group_name, g.group_index
            FROM ' . TABLE_USERS . '
            LEFT JOIN ' . TABLE_GROUPS . ' ON g.group_id = u.group_id
            WHERE is_deleted = 0
            ORDER BY user_registered DESC
            LIMIT ?
        ', [$number], ROWS);
    }

    /**
     * Returns user by forgot code
     *
     * @param string $forgotCode Forgot code
     * 
     * @return array
     */
    public function getByForgotCode( string $forgotCode )
    {
        return $this->db->query('
            SELECT user_id
            FROM ' . TABLE_FORGOT . '
            WHERE forgot_code = ?
        ', [$forgotCode]);
    }

    /**
     * Returns user by verify code
     *
     * @param string $verifyCode Verify code 
     * 
     * @return array
     */
    public function getByVerifyCode( string $verifyCode )
    {
        return $this->db->query('
            SELECT user_id
            FROM ' . TABLE_VERIFY . '
            WHERE verify_code = ?
        ', [$verifyCode]);
    }

    /**
     * Returns id of all registered users
     *
     * @return array
     */
    public function getAllID()
    {
        return array_column($this->db->query('SELECT user_id FROM ' . TABLE_USERS . ' WHERE is_deleted = 0', [], ROWS), 'user_id');
    }
}