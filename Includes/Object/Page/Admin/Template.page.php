<?php

namespace Page\Admin;

use Visualization\Lists\Lists;
use Visualization\Breadcrumb\Breadcrumb;

class Template extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'permission' => 'admin.template'
    ];

    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('template')->active();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        $templates = [];

        foreach (glob(ROOT . '/Styles/*', GLOB_ONLYDIR) as $path) {

            if (file_exists($path . '/Info.json')) {

                $json = json_decode(file_get_contents($path . '/Info.json'), true);

                if (basename($path) != $this->system->settings->get('site.template')) {
                    $templates[] = [
                        'template_name' => $json['name'],
                        'template_name_folder' => basename($path)
                    ];
                }
            }
        }

        // LIST
        $list = new Lists('Admin/Template');
        $list->object('current')->appTo(['template_name' => $this->system->template->get('name')])
            ->object('loaded')->fill($templates);
        $this->data->list = $list->getData();

        // REFRESH TEMPLATE
        $this->process->call(type: 'Admin/Template/Refresh', data: [
            'template_name' => $this->system->template->get('name'),
            'options' => [
                'on' => [$this->getOperation() => 'refresh']
            ]
        ]);

        // TEMPLATES FOLDER NAMES
        $templatesNamesFolder = array_column($templates, 'template_name_folder');

        switch ($this->getOperation()) {

            // SET TEMPLATE AS DEFAULT
            case 'set':
                
                if (in_array($this->getParam('set'), $templatesNamesFolder)) {

                    $this->process->call(type: 'Admin/Template/Set', data: [
                        'template_name' => $templates[array_search($this->getParam('set'), $templatesNamesFolder)]['template_name'],
                        'template_name_folder' => $this->getParam('set')
                    ]);
                }
            break;
        }

    }
}