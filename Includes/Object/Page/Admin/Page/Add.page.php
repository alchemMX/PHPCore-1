<?php

namespace Page\Admin\Page;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Add
 */
class Add extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'template' => 'page/page',
        'redirect' => '/admin/page/',
        'permission' => 'admin.page'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    public function body()
    {
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Page');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Page');
        $field->object('page')->title('L_PAGE_NEW');
        $this->data->field = $field->getData();

        // CREATE PAGE
        $this->process->form('Admin/Page/Create');
    }
}