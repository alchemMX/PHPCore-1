<?php

namespace Model;

use Model\Cookie;
use Model\Permission;
use Model\Database\Query;

use Block\User as BlockUser;

/**
 * User
 */
class User
{
    /**
     * @var object $perm Permission model
     */
    public \Model\Permission $perm;

    /**
     * @var bool $admin True if logged user is admin
     */
    public bool $admin = false;

    /**
     * @var int $index Logged user group index
     */
    public int $index = 0;

    /**
     * @var array $data Logged user data
     */
    private array $data = [];
    
    /**
     * Constructor
     * 
     * Gets data about logged user.
     */
    public function __construct()
    {
        $this->db = new Query();
        $this->perm = new Permission();

        $hash = Cookie::exists('token') ? Cookie::get('token') : Session::get('token');

        if ($hash) {

            $user = new BlockUser();

            if ($this->data = $user->getByHash((string)$hash)) {

                $this->data['unread'] = $user->getUnread($this->data['user_id']);
                $this->data['user_last_activity'] = date(DATE);
                $this->data['groupPermission'] = array_filter(explode(',', $this->data['group_permission']));
                $this->data['group_index'] = $this->data['is_admin'] == 1 ? 9999999999 + 1 : (int)$this->data['group_index'];

                $this->index = $this->data['group_index'];
                $this->admin = (bool)$this->data['is_admin'];

                if ($this->data['is_admin'] == 1) {
                    $this->perm->admin();
                }
                $this->perm->setIndex($this->data['group_index']);
                $this->perm->set($this->data['groupPermission']);

                // UPDATE LAST ACTIVITY
                $this->db->update(TABLE_USERS, [
                    'user_last_activity' => DATE_DATABASE
                ], $this->data['user_id']);

                return true;


            }
        }

        return false;
    }

    /**
     * Checks whether user is logged
     *
     * @return bool
     */
    public function isLogged() 
    {
        if (empty($this->data) === false) {
            return true;
        }
        
        return false;

    }

    /**
     * Gets given value from user data
     *
     * @param string|null $value If null method returns all data
     * 
     * @return string|array
     */
    public function get( string $value = null )
    {
        if (is_null($value)) {
            return $this->data;
        }

        return $this->data[$value];
    }

    /**
     * Changes user information
     *
     * @param string $value
     * @param mixed $mixed
     * 
     * @return void
     */
    public function set( string $column, $mixed )
    {
        $this->data[$column] = $mixed;
    }
}
