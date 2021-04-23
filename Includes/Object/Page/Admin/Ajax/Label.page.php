<?php

namespace Page\Admin\Ajax;

use Block\Label as BlockLabel;

use Model\Get;

/**
 * Ajax page
 */
class Label extends \Page\Page
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

        // BLOCK
        $label = new BlockLabel();

        // GET DATA
        if ($data = $label->get($get->get('id'))) {

            // RETURN DATA
            $this->data->data([
                'status' => 'ok',

                'buttonTitle' => $this->language->get('L_LABEL_EDIT'),

                'label_name' => $data['label_name'],
                'label_color' => $data['label_color']
            ]);
        }
    }
}