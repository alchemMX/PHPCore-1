<?php

namespace Exception;

/**
 * Notice exception
 */
class Notice extends \Exception {

    /**
     * Construct
     *
     * @param string $exceptionMessage
     */
    public function __construct( string $message )
    {
        global $router;

        $language = $router::$language;

        $noticeMessage = $language['notice'][$message] ?? '';

        if (empty($noticeMessage)) {
            $noticeMessage = $message;
        }

        $router->showPage($noticeMessage);
        exit();
    }
}