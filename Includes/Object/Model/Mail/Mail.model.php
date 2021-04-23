<?php

namespace Model\Mail;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Mail
 */
class Mail extends \Model\Model
{
    /**
     * @var object $mail PHPMailer
     */
    public object $mail;
      
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        require ROOT . '/Assets/PHPMailer/Exception.php';
        require ROOT . '/Assets/PHPMailer/PHPMailer.php';
        require ROOT . '/Assets/PHPMailer/SMTP.php';

        $this->mail = new PHPMailer(true);

        try {
            //Server settings
            $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $this->mail->Debugoutput = 'error_log';
            $this->mail->CharSet = 'UTF-8';

            if ($this->system->settings->get('email.smtp_enabled')) {
                $this->mail->isSMTP();
                $this->mail->Host       = $this->system->settings->get('email.smtp_host');
                $this->mail->SMTPAuth   = true;
                $this->mail->Username   = $this->system->settings->get('email.smtp_username');
                $this->mail->Password   = $this->system->settings->get('email.smtp_password');
                $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $this->mail->Port       = (int)$this->system->settings->get('email.smtp_port');
            }

            $this->mail->setFrom($this->system->settings->get('email.prefix') . '@' . $_SERVER['SERVER_NAME'], $this->system->settings->get('site.name'));

        } catch (Exception $e) {
            throw new \Exception\Notice($this->mail->ErrorInfo);
        }

    }

    /**
     * Assigns data to email body
     *
     * @return void
     */
    public function assign( array $data )
    {
        $_data = [];
        foreach ($data as $key => $value) {
            $_data['{' . $key . '}'] = $value;
        }

        $this->mail->Body = strtr($this->mail->Body, $_data);
    }

    /**
     * Sends email
     *
     * @return void
     */
    public function send()
    {
        $this->mail->isHTML(true);
        try {
            $this->mail->send();
        } catch (Exception $e) {
            throw new \Exception\Notice($this->mail->ErrorInfo);
        }
    }
}

