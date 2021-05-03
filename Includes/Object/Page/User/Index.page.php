<?php

namespace Page\User;

use Visualization\Field\Field;
use Visualization\Sidebar\Sidebar;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Index
 */
class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'template' => 'User/About',
        'loggedIn' => true
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('User/Index');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('User/Index');
        $field->data($this->user->get());
        $field->disButtons();
        $this->data->field = $field->getData();

        // SIDEBAR
        $sidebar = new Sidebar('User');
        $sidebar->left();
        $sidebar->small();
        $this->data->sidebar = $sidebar->getData(); 
    }
}