<?php

namespace Exception;

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
        $language = \Page\Page::$language;
        extract((array)$language);

        $error = $language[$error] ?? $error;

        if (isset($assignData)) {

            foreach ($assignData as $key => $value) {
                $assignData['{' . $key . '}'] = $value;
            }

            $error = strtr($error, $assignData);
        }


        require ROOT . '/Includes/Exception/Template/body.phtml';
        exit();
    }

}
