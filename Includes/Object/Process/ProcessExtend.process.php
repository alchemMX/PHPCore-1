<?php

namespace Process;

use Model\Database\Query;

/**
 * ProcessExtend
 */
class ProcessExtend {

    /**
     * @var string $redirectURL Url where will be user redirected after process execution
     */
    public string $redirectURL = '';

    /**
     * @var string $process Name of process
     */
    private string $process;

    /**
     * @var int $id Id
     */
    protected int $id;
    
    /**
     * @var object $db Database
     */
    public \Model\Database\Query $db;
    
    /**
     * @var object $perm Permission model
     */
    protected \Model\Permission $perm;

    /**
     * @var object $data ProcessData
     */
    protected \Process\ProcessData $data;

    /**
     * @var object $system System model
     */
    protected \Model\System\System $system;

    /**
     * @var object $check ProcessCheck
     */
    protected \Process\ProcessCheck $check;
        
    /**
     * Constructor
     *
     * @param  string $process Name of process
     * @param  \Model\System\System $system System model
     * @param  \Model\Permission $perm Permission model
     * 
     * @return void
     */
    public function __construct( string $process, \Model\System\System $system , \Model\Permission $perm )
    {
        $this->db = new Query();
        $this->perm = $perm;
        $this->check = new ProcessCheck();
        $this->system = $system;
        $this->process = $process;
    }

    public function getID()
    {
        return $this->id ?? $this->db->lastInsertId();
    }
    
    /**
     * Loads data to process
     *
     * @param  array $data The data
     * 
     * @return void
     */
    public function data( array $data )
    {
        $this->data = new ProcessData($data);
    }

    /**
     * Sets redirect url
     *
     * @param  string $path URL
     * 
     * @return void
     */
    protected function redirectTo( string $path )
    {
        $this->redirectURL = $path;
    }

    /**
     * Adds record to log
     * 
     * @param string $text Usually some name of forum, group, user etc...
     *
     * @return void
     */
    protected function log( string $text = null )
    {
        $this->db->insert(TABLE_LOG, [
            'user_id'       => LOGGED_USER_ID,
            'log_text'      => $text ?? '',
            'log_action'    => $this->process
        ]);
    }

    /**
     * Sends notification to user
     * 
     * @param int $id Id of item
     * @param int $to User id
     * @param bool $replace If true and user will have unreaded this notification, time will be updated otherwise will be inserted to db another record.
     *
     * @return void
     */
    protected function notifi( int $id, int $to, bool $replace = false )
    {
        if (LOGGED_USER_ID == $to) {
            return;
        }

        $_id = '';
        if ($replace === true) {
            $_id = $this->db->query('
                SELECT user_notification_id
                FROM ' . TABLE_USERS_NOTIFICATIONS . '
                WHERE user_notification_type = ? AND user_notification_type_id = ? AND user_id = ?
            ', [$this->process, $id, LOGGED_USER_ID]);
        }

        if (isset($_id['user_notification_id'])) {
            $this->db->query('UPDATE ' . TABLE_USERS_NOTIFICATIONS . ' SET user_notification_time = NOW() WHERE user_notification_id = ?', [$_id['user_notification_id']]);
        } else {
            $this->db->insert(TABLE_USERS_NOTIFICATIONS, [
                'user_id'                       => LOGGED_USER_ID,
                'to_user_id'                    => (int)$to,
                'user_notification_type'        => $this->process,
                'user_notification_type_id'     => (int)$_id ?: $id
            ]);
        }
    }
    
    /**
     * Updates system session
     *
     * @return void
     */
    protected function updateSession()
    {
        $settings = json_decode(file_get_contents(ROOT . '/Includes/Settings/Settings.json'), true);
        $settings['session'] = RAND;
        file_put_contents(ROOT . '/Includes/Settings/Settings.json', json_encode($settings),  JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}