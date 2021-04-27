<?php

namespace Page\Ajax;

use Model\Get;

/**
 * Language
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

        switch ($get->get('process')) {

            case 'Post/Editor':
            case 'ProfilePost/Editor':
            case 'ProfilePostComment/Editor':
            case 'ConversationMessage/Editor':
                $this->data->data([
                    'button' => $this->file('/Blocks/Block/Buttons/Save.phtml'),
                    'status' => 'ok'
                ]);
            break;

            case 'Post/Delete':
            case 'ProfilePost/Delete':
            case 'ProfilePostComment/Delete':
                $this->data->data([
                    'windowTitle' => $this->language->get('L_WINDOW_CONFIRM'),
                    'windowDesc' => $this->language->get('L_WINDOW')[$get->get('process')],
                    'windowClose' => $this->language->get('L_NO'),
                    'windowSubmit' => $this->language->get('L_YES'),
                    'status' => 'ok'
                ]);
            break;

            case 'Post/Report':
            case 'Topic/Report':
            case 'ProfilePost/Report':
            case 'ProfilePostComment/Report':
            
                $this->data->data([
                    'windowDesc' => $this->language->get('L_WINDOW_REPORT_DESC'),
                    'windowTitle' => $this->language->get('L_WINDOW_REPORT_TITLE'),
                    'windowClose' => $this->language->get('L_CANCEL'),
                    'windowSubmit' => $this->language->get('L_SUBMIT'),
                    'windowContent' => '<textarea></textarea>',
                    'status' => 'ok'
                ]);
            break;
        }
    }
}