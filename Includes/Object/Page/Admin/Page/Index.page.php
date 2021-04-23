<?php

namespace Page\Admin\Page;

use Block\Page as BlockPage;

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
        'permission' => 'admin.page'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('page')->active();

        // BLOCK
        $page = new BlockPage();
        
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Page/Index');
        $this->data->field = $field->getData();

        // LIST
        $list = new Lists('Admin/Page');
        $list->object('page')->fill($page->getAll());
        $this->data->list = $list->getData();

        // CREATE NEW PAGE
        $this->process->form(type: 'Admin/Page/Create');
    }
}