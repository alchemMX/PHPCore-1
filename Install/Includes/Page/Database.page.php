<?php

namespace Page;

/**
 * Database
 */
class Database extends Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {   
        $this->templateName = 'Database';

        // SETUP DATABASE
        $this->process->form(type: 'Database');
    }
}