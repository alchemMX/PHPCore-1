<?php

namespace Model\Account;

use Model\Cookie;
use Model\Session;
use Model\Database\Query;

use Block\User;

/**
 * Login
 */
class Login
{
    /**
     * @var string $username Username of user
     */
    private string $username;

    /**
     * @var string $password Password of user
     */
    private string $password;

    /**
     * @var bool $remember True if user wants to remember login
     */
    private bool $remember = false;

    /**
     * @var array $result Database data
     */
    private array $result;

    /**
     * @var object $user User block
     */
    private \Block\User $user;

    /**
     * Constructor
     * 
     * Loads login informations
     *
     * @param string $username
     * @param string $pasword
     * @param int $remember
     */
    public function __construct( string $username, string $password, int $remember )
    {
        $this->username = $username;
        $this->password = $password;
        $this->remember = (bool)$remember;

        $this->db = new Query();
        $this->user = new User();
    }

    /**
     * Checks if login is valid
     *
     * @return bool
     */
    private function validate()
    {
        if ($this->isAccountExists() === true) {
            if ($this->isAccountActivated() === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if given account exists
     *
     * @return bool
     */
    private function isAccountExists()
    {    
        if ($this->result = $this->user->getByName($this->username) ?: []) {
            if (password_verify($this->password, $this->result['user_password'])) {
                return true;
            }
        }

        throw new \Exception\Notice('login_validate');
        return false;
    }

    /**
     * Checks if given account is activated
     *
     * @return bool
     */
    private function isAccountActivated()
    {
        if (!$this->result['verify_code']) {
            return true;
        }

        throw new \Exception\Notice('account_not_activated', [
            'url' => $this->system->url->build('/login/send-' . $this->result['user_id'])
        ]);
        return false;
    }

    /**
     * Logs user
     *
     * @return void
     */
    public function login()
    {
        if ($this->validate() !== true) {
            return false;
        }

        $this->db->query('UPDATE ' . TABLE_USERS . ' SET user_hash = ?, user_last_activity = NOW() WHERE user_id = ?', [$token = md5(uniqid(mt_rand(), true)), $this->result['user_id']]);

        if ($this->remember === true) {

            Cookie::put('token', $token, 24 * 3600);
            Session::delete('token');

        } else {

            Session::put('token', $token);
            Cookie::delete('token');
        }
    }

}
