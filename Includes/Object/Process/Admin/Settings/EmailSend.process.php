<?php

namespace Process\Admin\Settings;

use Model\Mail\MailTest;

class EmailSend extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [];

    /**
     * @var array $options Process options
     */
    public $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $email = $this->db->query('SELECT user_email FROM ' . TABLE_USERS . ' WHERE is_admin = 1');

        $mail = new MailTest();
        $mail->mail->addAddress($email['user_email']);
        $mail->send();
    }
}