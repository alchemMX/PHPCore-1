<?php

namespace Page\Admin\Ajax;

use Model\Get;

/**
 * Update
 */
class Update extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'loggedIn' => true,
        'permission' => 'admin.settings'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $get = new Get();

        if ($get->is('error')) {

            $this->data->data([
                'url' => $this->system->url->build('/admin/update/'),
                'back' => $this->language->get('L_BACK'),
                'text' => $this->language->get('L_UPDATE_ERROR'),
                'error' => $this->language->get('L_UPDATE_ERROR_DESC'),
                'status' => 'error'
            ]);

        } else {
            
            if (empty($GLOBALS['GITHUB']) or $GLOBALS['GITHUB'][0]['tag_name'] == $this->system->settings->get('site.version')) {
                $this->data->data([
                    'url' => $this->system->url->build('/admin/update/'),
                    'back' => $this->language->get('L_BACK'),
                    'text' => $this->language->get('L_UPDATE_INSTALLED_ALREADY'),
                    'status' => 'current'
                ]);
            } else {

                if ($this->process->call(type: 'Admin/Update', mode: 'direct', data: ['path' => $GLOBALS['GITHUB'][0]['zipball_url'], 'tag' => $GLOBALS['GITHUB'][0]['tag_name']])) {
                    $this->data->data([
                        'url' => $this->system->url->build('/admin/update/'),
                        'text' => strtr($this->language->get('L_UPDATE_INSTALLED'), ['{name}' => $GLOBALS['GITHUB'][0]['name'] ?: $GLOBALS['GITHUB'][0]['tag_name']]),
                        'back' => $this->language->get('L_BACK'),
                        'status' => 'installed',
                    ]);
                } else {


                    $this->data->data([
                        'url' => $this->system->url->build('/admin/update/'),
                        'back' => $this->language->get('L_BACK'),
                        'text' => $this->language->get('L_UPDATE_ERROR'),
                        'error' => $this->language->get('L_UPDATE_ERROR_DESC'),
                        'status' => 'error'
                    ]);

                }
            }
        }
    }
}