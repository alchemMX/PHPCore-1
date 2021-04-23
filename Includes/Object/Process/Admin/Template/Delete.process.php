<?php

namespace Process\Admin\Template;

use Model\File;

class Delete extends \Process\ProcessExtend
{    
    /**
     * @var array $require Required data
     */
    public $require = [
        'data' => [
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
        $file = new File();
        $file->delete(ROOT . '/Styles/' . $this->data->get('template_name_folder'));

        // ADD RECORD TO LOG
        $this->log($this->data->get('template_name_folder'));
    }
}