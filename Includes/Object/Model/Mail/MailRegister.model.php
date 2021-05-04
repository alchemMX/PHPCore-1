<?php

namespace Model\Mail;

/**
 * MailRegister
 */
class MailRegister extends Mail
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->mail->Subject = $this->system->settings->get('site.name') . ' - ' . $this->language->get('L_MAIL_ACTIVATION_SUBJECT');
        $this->mail->Body    = strtr($this->language->get('L_MAIL_ACTIVATION_BODY'), [
            '{domain}' => $_SERVER['SERVER_NAME'],
            '{protocol}' => $_SERVER['REQUEST_SCHEME']
        ]);
    }
}

