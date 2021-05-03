<?php

namespace Process\Admin\Settings;

/**
 * Index
 */
class Index extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'site_name'         => [
                'type' => 'text',
                'required' => true
            ],
            'site_description'  => [
                'type' => 'text',
                'required' => true
            ],
            'image_max_size'    => [
                'type' => 'number',
                'required' => true
            ],
            'cookie_enabled'    => [
                'type' => 'checkbox'
            ],
            'cookie_text'       => [
                'type' => 'text'
            ]
        ]
    ];

    /**
     * @var array $options Process options
     */
    public array $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $settings = $this->system->settings->get();
        $settings['site.name'] = $this->data->get('site_name');
        $settings['site.description'] = $this->data->get('site_description');
        $settings['image.max_size'] = $this->data->get('image_max_size');
        $settings['cookie.enabled'] = $this->data->get('cookie_enabled');
        $settings['cookie.text'] = $this->data->get('cookie_text');
        $this->system->settings->set($settings);
        
        $this->updateSession();

        // ADD RECORD TO LOG
        $this->log();
    }
}