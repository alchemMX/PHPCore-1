<?php

namespace Page;

use Block\User;

/**
 * Verify page
 */
class Verify extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => string,
        'loggedOut' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // IF CODE IS ENTERED
        if ($this->getID()) {

            if ($data = (new User)->getByVerifyCode($this->getID())) {
                    
                // VERIFY USER
                $this->process->call(type: 'Verify/Verify', data: [
                    'user_id' => $data['user_id']
                ]);
            }
        }

        redirect('/');
        exit();
    }
}