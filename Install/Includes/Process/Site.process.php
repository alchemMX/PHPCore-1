<?php

namespace Process;

class Site extends Process
{    
    /**
     * @var array $require Required data
     */
    public array $require = [
        'form' => [
            'name'      => [
                'type' => 'text',
                'required' => true
            ],
            'description'  => [
                'type' => 'text',
                'required' => true
            ]
        ]
    ];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $settings = [];
        $settings['site.started'] = DATE_DATABASE;
        $settings['site.name'] = $this->data->get('name');
        $settings['site.updated'] = DATE_DATABASE;
        $settings['site.description'] = $this->data->get('description');
        $this->system->set($settings);

        $this->system->install([
            'db' => true,
            'page' => 6
        ]);
    }
}