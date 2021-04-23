<?php

namespace Page\Admin\Ajax;

use Model\Get;

/**
 * Languages pack for ajax
 */
class Language extends \Page\Page
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

        $get->get('process') or exit();

        $this->data->data([
            'windowTitle' => $this->language->get('L_WINDOW_CONFIRM_ACTION'),
            'windowDesc' => $this->language->get('L_WINDOW_DESC')[$get->get('process')],
            'windowClose' => $this->language->get('L_NO'),
            'windowSubmit' => $this->language->get('L_YES'),
            'status' => 'ok'
        ]);
    }
}