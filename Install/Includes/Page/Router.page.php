<?php

namespace Page;

use Model\System;

use Process\Process;

/**
 * Main router
 */
class Router extends Page
{
    /**
     * Constructor
     * Loads basic models and process
     *
     * @return void
     */
    public function __construct()
    {
        self::$data = new \stdClass();

        // SYSTEM
        $this->system = new System();

        // PROCESS
        $this->process = new Process();
        $this->process->system = $this->system;
    }
    
    /**
     * Body of this page
     *
     * @return void
     */
    public function body()
    {
        // TEMPLATE
        $this->templateName = 'Body';

        $settings = json_decode(file_get_contents(ROOT . '/Install/Includes/Settings.json'), true);

        require ROOT . '/Languages/' . ($this->system->get('site.language') ?? 'cs') . '/Install/Load.language.php';
        self::$language = $language;

        self::$data->page = $settings['page'];

        if (isset($_GET['repeat'])) {

            $this->system->install([
                'db' => false,
                'page' => 0,
            ]);
            redirect('/Install/');
        }

        if (isset($_GET['install'])) {

            $this->page = new \Page\Ajax\Installation();
            $this->page->system = $this->system;
            $this->page->body();
        }

        $this->page = match((int)$settings['page']) {
            0 => new \Page\Index(),
            1 => new \Page\Language(),
            2 => new \Page\Database(),
            3 => new \Page\Installation(),
            4 => new \Page\Admin(),
            5 => new \Page\Site(),
            6 => new \Page\End()
        };
        
        $this->page->system = $this->system;
        $this->page->process = $this->process;

        // STARTS
        $this->page->body();

    }
}