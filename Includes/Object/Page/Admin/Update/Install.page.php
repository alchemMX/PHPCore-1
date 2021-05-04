<?php

namespace Page\Admin\Update;

/**
 * Install
 */
class Install extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'permission' => 'admin.settings'
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        extract($this->language->get());

        require ROOT . '/Includes/Update/html.phtml';
        exit();
    }
}