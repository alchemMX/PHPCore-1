<?php

namespace Exception;

use Model\Language;

/**
 * System exception 
 */
class System extends \Exception {

    /**
     * Construct
     *
     * @param string $error The error
     */
    public function __construct( string $error )
    {
        $language = new Language();

        if (AJAX === true) {
            echo json_encode([
                'status' => 'error',
                'error' => $error,
                'title' => $language->get('L_INSTALL_ERROR'),
                'button' => $language->get('L_RETRY')
            ]);

            exit();
        }

        extract($language->get());

        require ROOT . '/Includes/Object/Exception/Template/Body.phtml';
        exit();
    }
}
