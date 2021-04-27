<?php

namespace Page\User\Conversation;

use Block\User;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Add
 */
class Add extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'editor' => EDITOR_BIG,
        'template' => 'User/Conversation/New',
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
        $field = new Field('User/Conversation');
        $field->object('conversation')
            ->row('add_recipient')->show()
            ->row('recipients')->show();
        $this->data->field = $field->getData();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('User/Conversation');
        $this->data->breadcrumb = $breadcrumb->getData();

        // NEW CONVERSATION
        $this->process->form(type: 'Conversation/Create');
    }
}