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
     */
    public function __construct( string $error, array $assignData = null )
    {
        $language = new Language();
        $system = new _System();
        extract($language->get());

        if (isset($assignData)) {

            foreach ($assignData as $key => $value) {
                $assignData['{' . $key . '}'] = $value;
            }

            $error = $language[$error] ? strtr($language->get($error), $assignData) : $error;
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
