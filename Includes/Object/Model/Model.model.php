<?php

namespace Model;

use \Model\Language;
use \Model\System\System;

/**
 * Model
 */
abstract class Model
{
    /**
     * @var object $language Language
     */
    protected \Model\Language $language;

    /**
     * @var object $language Language
     */
    protected \Model\System\System $system;
    
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->system = new System();
        $this->language = new Language();
    }
}