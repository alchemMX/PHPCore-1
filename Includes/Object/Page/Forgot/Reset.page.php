<?php

namespace Page\Forgot;

use Block\User;

use Visualization\Field\Field;

/**
 * Reset forgotten pasword page
 */
class Reset extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => string,
        'template' => 'Forgot/Change',
        'loggedOut' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // BLOCK
        $user = new user();

        if ($forgot = $user->getByForgotCode((string)$this->getID())) {

            // FIELD
            $field = new Field('User/Forgot/Change');
            $this->data->field = $field->getData();

            // RESET PROCESS
            $this->process->form(type: 'Forgot/Reset', data: [
                'user_id'   => $forgot['user_id'],
                'options'   => [
                    'url'   => '/'
                ]
            ]);
        } else redirect('/');
    }
}