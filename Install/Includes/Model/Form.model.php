<?php

namespace Model;

/**
 * Form Class
 */
class Form
{

    public function get( string $what )
    {
        return strip_tags(isset($_POST[$what]) ? $_POST[$what] : '');
    }
    
    public function getData()
    {
        return $_POST;
    }

    /**
     * Checks whether submit button was pressed.
     *
     * @param string $buttonName
     * @return bool
     */
    public function isSend( string $buttonName )
    {
        if (isset($_POST['key']) and $_POST['key'] == SESSION_ID) {
            if (isset($_POST[$buttonName])) {
                
                return true;
            }
        }

        return false;
    }

}
