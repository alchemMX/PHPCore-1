<?php

namespace Page;

use Model\Form;
use Model\Session;
use Model\System\System;

/**
 * Page
 */
abstract class Page
{
    /**
     * @var array $language Language
     */
    public static $language;

    /**
     * @var array $head Head of page
     */
    protected $head = ['title', 'description', 'keyWords'];
    
    /**
     * @var string $templateName Name of default template
     */
    protected $templateName;
    
    /**
     * @var string $favicon Favicon
     */
    protected $favicon = '/Uploads/Site/PHPCore_icon.svg';
    
    /**
     * @var object $page Page class
     */
    protected $page;

    /**
     * @var object $page Process
     */
    protected \Process\process $process;

    /**
     * @var object $system System model
     */
    protected \Model\System $system;

    /**
     * @var object $data Page data
     */
    protected static $data;

    /**
     * Displays page
     *
     * @param string $exceptionMessage
     * @return void
     */
    public function showPage( string $exceptionMessage = null )
    {
        // EXTRACT LANGUAGE
        extract(self::$language);

        // IF IS ENTERED EXCEPTION MESSAGE
        if (!is_null($exceptionMessage)) {
            self::$data->notice = $exceptionMessage;
        }

        $form = new Form();

        require ROOT . '/Install/Style/Templates/' . $this->templateName . '.phtml';
    }

    /**
     * Body method for every page
     *
     * @return void
     */
    abstract protected function body();
}