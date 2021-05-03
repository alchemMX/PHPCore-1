<?php

namespace Page\Admin\Ajax;

use Model\Get;

/**
 * Language
 */
class Language extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'loggedIn' => true,
        'permission' => 'admin.?'
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
            'windowClose' => $this->language->get('L_NO'),
            'windowSubmit' => $this->language->get('L_YES'),
            'windowContent' => $this->language->get('L_WINDOW_DESC')[$get->get('process')],
            'status' => 'ok'
        ]);
    }
}