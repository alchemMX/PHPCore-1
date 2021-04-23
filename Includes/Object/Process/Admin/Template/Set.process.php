<?php

namespace Process\Admin\Template;

class Set extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
            'template_name',
            'template_name_folder'
        ]
    ];

    /**
     * @var array $options Process options
     */
    public $options = [];

    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $this->system->settings->set('site.template', $this->data->get('template_name_folder'));

        // ADD RECORD TO LOG
        $this->log($this->data->get('template_name_folder'));
    }
}