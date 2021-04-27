<?php

namespace Process;

class Language extends Process
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'language'      => [
                'type' => 'string',
                'required' => true
            ]
        ],
        'data' => [
            'languageList'
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        if (in_array($this->data->get('language'), $this->data->get('languageList'))) {

            $this->system->install([
                'db' => false,
                'page' => 2
            ]);

            $this->system->set('site.language', $this->data->get('language'));
        }
    }
}