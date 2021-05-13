<?php

namespace Page;

use Model\Form;

/**
 * Page
 */
abstract class Page
{
    /**
     * @var array $head Head of page
     */
    protected array $head = ['title', 'description', 'keyWords'];
    
    /**
     * @var string $templateName Name of default template
     */
    protected string $templateName;
    
    /**
     * @var string $favicon Favicon
     */
    protected string $favicon = '/Uploads/Site/PHPCore_icon.svg';
    
    /**
     * @var object $page Page class
     */
    protected object $page;

    /**
     * @var \Model\Data $data Data
     */
    protected \Model\Data $data;

    /**
     * @var \Model\Language $language Language
     */
    public \Model\Language $language;

    /**
     * @var \Model\System $system System
     */
    protected \Model\System $system;

    /**
     * @var \Process\process $page Process
     */
    protected \Process\process $process;

    /**
     * Displays page
     *
     * @param string $notice Notice
     * 
     * @return void
     */
    public function showPage( string $notice = null )
    {
        // IF IS ENTERED EXCEPTION MESSAGE
        if (!is_null($notice)) {
            $this->data->data([
                'notice' => $notice
            ]);
        }

        // EXTRACT LANGUAGE
        extract($this->language->get());

        $form = new Form();

        require ROOT . '/Install/Style/Templates/' . $this->templateName . '.phtml';
    }
    
    /**
     * Shows notice to page
     *
     * @param  string $notice The notice
     * 
     * @return void
     */
    public function notice( string $notice )
    {
        $message = $this->language->get('L_NOTICE')[$notice] ?? $notice;
        $this->showPage($message);
    }

    /**
     * Body method for every page
     *
     * @return void
     */
    abstract protected function body();
}