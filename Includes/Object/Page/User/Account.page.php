<?php

namespace Page\User;

use Visualization\Field\Field;
use Visualization\Sidebar\Sidebar;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Account page
 */
class Account extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'User/Account',
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
        $field = new Field('User/Account');
        $field->data($this->user->get());
        $this->data->field = $field->getData();

        // SIDEBAR
        $sidebar = new Sidebar('User');
        $sidebar->left();
        $sidebar->small();
        $this->data->sidebar = $sidebar->getData(); 

        // PROCESS
        $this->process->form(type: 'User/Account', data: [
            'current_user_password' => $this->user->get('user_password')
        ]);
    }
}