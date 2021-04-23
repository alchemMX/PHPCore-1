<?php

namespace Page;

/**
 * Site settings page
 */
class Site extends Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {   
        $this->templateName = 'Site';

        // SETUP DATABASE
        $this->process->form(type: 'Site');
    }
}