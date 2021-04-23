<?php

namespace Page\Admin\Label;

use Block\Label as Label;

use Visualization\Field\Field;
use Visualization\Lists\Lists;
use Visualization\Breadcrumb\Breadcrumb;

class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'permission' => 'admin.label'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('forum')->row('label')->active();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // BLOCK
        $label = new Label();

        // LIST
        $list = new Lists('Admin/Label');
        $list->object('label')->fill($label->getAll());
        $this->data->list = $list->getData();

        // FIELD
        $field = new Field('Admin/Label/Index');
        $this->data->field = $field->getData();

        // NEW LABEL
        $this->process->form(type: 'Admin/Label/Create');
    }
}