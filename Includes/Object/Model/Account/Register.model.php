<?php

namespace Model\Account;

use Model\System\System;
use Model\Database\Query;

use Block\User;


/**
 * Register
 */
class Register extends \Model\Model
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
     * @var string $email Email of user
     */
    private string $email;

    /**
     * @var string $token Token of recaptcha
     */
    private string $token;

    /**
     * @var string $code Generated code for new user to activate account
     */
    private string $code;

    /**
     * @var string $url URL of recaptcha
     */
    public string $url = 'https://www.google.com/recaptcha/api/siteverify';

    /**
     * @var object $user User block
     */
    private \Block\User $user;

    /**
     * @var object $db Query
     */
    private \Model\Database\Query $db;

    /**
     * Constructor
     * 
     * Loads register informations
     *
     * @param string $username
     * @param string $password
     * @param string $email
     * @param string $token
     */
    public function __construct( string $username, string $password, string $email, string $token )
    {
        parent::__construct();

        $this->db = new Query();
        $this->user = new User();

        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->token = $token;
    }

    /**
     * Checks if given account is valid
     *
     * @return bool
     */
    private function validate()
    {
        if ($this->recaptcha() === true) {
            if ($this->exists() === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Checks if recaptcha is valid
     *
     * @return bool
     */
    private function recaptcha()
    {
        $data = [
            'secret' => $this->system->settings->get('registration.key_secret'),
            'response' => $this->token,
            'remoteip' => $_SERVER['REMOTE_ADDR']
        ];

        $options = array(
            'http' => array(
                'header'  => 'Content-type: application/x-www-form-urlencoded\r\n',
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );

        $mysqliText  = stream_context_create($options);
  	    $response = file_get_contents($this->url, false, $mysqliText);
        $res = json_decode($response, true);

        if ($res['success'] == true) {
            return true;
        } 

        throw new \Exception\Notice('recaptcha');
        return false;

    }

    /**
     * Checks if given account exists
     *
     * @return bool
     */
    private function exists()
    {        
        if (empty($this->user->getByName($this->username))) {
            
            if (empty($this->user->getByEmail($this->email))) { 
                return true;
            }

            throw new \Exception\Notice('user_email_exist');
            return false;
        }

        throw new \Exception\Notice('user_name_exist');
        return false;
    }

    /**
     * Registers user
     *
     * @return bool
     */
    public function register()
    {
        if ($this->validate() !== true) {
            return false;
        }

        $this->db->insert(TABLE_USERS, [
            'group_id' => $this->system->settings->get('default_group'),
            'user_name' => $this->username,
            'user_email' => $this->email,
            'user_password' => password_hash($this->password, PASSWORD_DEFAULT),
            'user_profile_image' => PROFILE_IMAGES_COLORS[rand(0, 6)]
        ]);
        
        $this->code = md5(mt_rand());

        $this->db->insert(TABLE_VERIFY, [
            'code' => $this->code,
            'user_id' => $this->db->lastInsertId()
        ]);

        return true;
    }

    /**
     * Returns generated code to activate account
     *
     * @return string The code
     */
    public function getCode()
    {
        return $this->code;
    }
}