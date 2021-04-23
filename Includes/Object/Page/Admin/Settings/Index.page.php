<?php

namespace Page\Admin\Settings;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'permission' => 'admin.settings'
    ];

    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('settings')->active()->option('site')->active();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Settings/Index');
        $field->data($this->system->settings->get());
        $this->data->field = $field->getData();

        // EDIT SETTINGS
        $this->process->form(type: 'Admin/Settings/Index');
    }
}