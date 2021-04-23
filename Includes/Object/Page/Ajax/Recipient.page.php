<?php

namespace Page\Ajax;

use Block\User;
use Block\Pm;

use Model\Get;

/**
 * Ajax page
 */
class Recipient extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'loggedIn' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $get = new Get();

        $get->get('id') or exit();
        $get->get('user') or exit();

        $pm = new Pm();
        $user = new User();

        $this->process->direct();

        if ($data = $user->getByName($get->get('user'))) {
            if ($data['user_id'] != LOGGED_USER_ID) {

                if ($recipients = array_column($count = $pm->getRecipients($get->get('id')), 'user_id')) {

                    if (count($count) < 10 ) {

                        if (in_array(LOGGED_USER_ID, $recipients) === true and in_array($data['user_id'], $recipients) === false) {

                            if ($this->process->call(type: 'Pm/Recipient', data: ['pm_id' => $get->get('id'), 'user_id' => $data['user_id']])) {;
                                $this->data->data([
                                    'user' => $this->build->user->linkImg($data),
                                    'status' => 'ok'
                                ]);
                            }
                        }
                    }
                }
            }
        }
    }
}