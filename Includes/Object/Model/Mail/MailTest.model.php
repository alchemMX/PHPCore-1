<?php

namespace Model\Mail;

/**
 * MailTest
 */
class MailTest extends Mail
{
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->mail->Subject = $this->system->settings->get('site.name') . ' - ' . $this->language->get('L_MAIL_TEST_SUBJECT');
        $this->mail->Body    = $this->language->get('L_MAIL_TEST_BODY');
    }
}