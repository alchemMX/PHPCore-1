<?php

namespace Process\Forgot;

use Model\Mail\MailForgot;

/**
 * Send
 */
class Send extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'user_email'    => [
                'type' => 'text',
                'required' => true
            ]
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
        if (!$data = (new \Block\User)->getByEmail($this->data->get('user_email'))) {
            throw new \Exception\Notice('user_email_no_exist');
            return false;
        }

        // GENERATE CODE
        $code = !$data['forgot_code'] ? substr(md5(RAND), 0, 15) : $data['forgot_code'];

        if (!$data['forgot_code']) {
            // INSERT CODE TO DATABASE
            $this->db->insert(TABLE_FORGOT, [
                'user_id' => $data['user_id'],
                'forgot_code' => $code
            ]);
        }

        // SEND MAIL WITH CODE
        $mail = new MailForgot();
        $mail->mail->addAddress($this->data->get('user_email'), $data['user_name']);
        $mail->assign(['code' => $code]);
        $mail->send();
    }
}