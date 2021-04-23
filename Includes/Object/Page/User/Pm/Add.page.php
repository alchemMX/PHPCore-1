<?php

namespace Page\User\Pm;

use Block\User;

Use Model\Get;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Private messages
 */
class Add extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'editor' => EDITOR_BIG,
        'template' => 'User/Pm/New',
        'loggedIn' => true
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // BLOCK
        $user = new User();

        // IF RECIPIENT IS DEFINED IN URL
        if ($this->getParam('to') and $this->getParam('to') != LOGGED_USER_ID) {
            $this->data->data['recipient'] = $user->get((int)$this->getParam('to'));
        }

        // FIELD
        $field = new Field('User/Pm');
        $field->object('pm')
            ->row('add_recipient')->show()
            ->row('recipients')->show();
        $this->data->field = $field->getData();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('User/Pm');
        $this->data->breadcrumb = $breadcrumb->getData();

        // NEW PRIVATE MESSAGE
        $this->process->form(type: 'Pm/Create');
    }
}