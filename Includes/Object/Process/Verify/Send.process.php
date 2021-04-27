<?php

namespace Process\Verify;

use Model\Mail\MailRegister;

class Send extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'data' => [
            'verify_code',
            'user_email'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [
        'login' => REQUIRE_LOGOUT
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        // SEND AN EMAIL TO VERIFY ACCOUNT
        $mail = new MailRegister();
        $mail->mail->addAddress($this->data->get('user_email'));
        $mail->assign(['code' => $this->data->get('verify_code')]);
        $mail->send();
    }
}