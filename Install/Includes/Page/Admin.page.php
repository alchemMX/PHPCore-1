<?php

namespace Page;

/**
 * Admin
 */
class Admin extends Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {   
        $this->templateName = 'Admin';

        // SETUP DATABASE
        $this->process->form(type: 'Admin');
    }
}