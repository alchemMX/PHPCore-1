<?php

namespace Page\Forgot;

use Visualization\Field\Field;

/**
 * Send email to reset password
 */
class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Forgot/Send',
        'loggedOut' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // FIELD
        $field = new Field('User/Forgot/Send');
        $this->data->field = $field->getData();

        // SEND FORGOT PASSWORD MAIL
        $this->process->form(type: 'Forgot/Send', url: '/'); 
    }
}