<?php

namespace Page\Forgot;

use Block\User;

use Visualization\Field\Field;

/**
 * Reset
 */
class Reset extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
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

        $data = $user->getByForgotCode((string)$this->getID());

        if (!$data) {
            redirect('/');
        }

        // FIELD
        $field = new Field('User/Forgot/Change');
        $this->data->field = $field->getData();

        // RESET PROCESS
        $this->process->form(type: 'Forgot/Reset', data: [
            'user_id'   => $data['user_id'],
            'options'   => [
                'url'   => '/'
            ]
        ]);
    }
}