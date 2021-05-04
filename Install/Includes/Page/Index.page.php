<?php

namespace Page;

/**
 * Index
 */
class Index extends Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {   
        $this->templateName = 'Index';

        $this->process->form(type: 'Start');
    }
}