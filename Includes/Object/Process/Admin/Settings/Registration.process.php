<?php

namespace Process\Admin\Settings;

class Registration extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'registration_enabled'      => [
                'type' => 'checkbox'
            ],
            'registration_key_site'     => [
                'type' => 'text'
            ],
            'registration_key_secret'   => [
                'type' => 'text'
            ],
            'registration_terms'   => [
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
        if ($this->data->is('registration_enabled')) {
            file_put_contents(ROOT . '/Assets/reCAPTCHA/reCAPTCHA.js', strtr(file_get_contents(ROOT . '/Assets/reCAPTCHA/reCAPTCHA.org.js'), ['{site_key}' => $this->data->get('registration_key_site')]));
        }

        $settings = $this->system->settings->get();
        $settings['registration.terms'] = $this->data->get('registration_terms');
        $settings['registration.key_site'] = $this->data->get('registration_key_site');
        $settings['registration.key_secret'] = $this->data->get('registration_key_secret');
        $settings['registration.enabled'] = $this->data->get('registration_enabled');
        $this->system->settings->set($settings);

        $this->updateSession();

        // ADD RECORD TO LOG
        $this->log();
    }
}