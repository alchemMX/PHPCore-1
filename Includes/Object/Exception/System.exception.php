<?php

namespace Exception;

use Model\Language;
use Model\System\System as _System;

/**
 * System exception 
 */
class System extends \Exception {

    /**
     * Construct
     *
     * @param string $error
     * @param array $assign
     */
    public function __construct( string $error, array $assign = null )
    {
        $language = new Language();
        $system = new _System();
        extract($language->get());

        if (isset($assign)) {

            foreach ($assign as $key => $value) {
                $assign['{' . $key . '}'] = $value;
            }

            $error = $language[$error] ? strtr($language->get($error), $assign) : $error;
        }

        if (defined('AJAX') and AJAX === true) {
            echo json_encode([
                'status' => 'error',
                'error' => $error,
                'title' => $language->get('L_INTERNAL_ERROR')
            ]);
            exit();
        }

        require ROOT . '/Includes/Object/Exception/Template/Body.phtml';
        exit();
    }
}
