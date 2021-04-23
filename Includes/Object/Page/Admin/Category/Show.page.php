<?php

namespace Page\Admin\Category;

use Block\Admin\Category;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Show extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => int,
        'template' => 'Overall',
        'redirect' => '/admin/forum/',
        'permission' => 'admin.forum'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('forum')->row('forum')->active();
        
        // BLOCK
        $category = new Category();

        // CATEGORY
        $category = $category->get($this->getID()) or $this->error();
        
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Forum');
        $this->data->breadcrumb = $breadcrumb->getData();
        
        // FIELD
        $field = new Field('Admin/Category/Category');
        $field->data($category);
        $field->object('category')->title('L_CATEGORY_EDIT');
        $this->data->field = $field->getData();

        // EDIT CATEGORY
        $this->process->form(type: 'Admin/Category/Edit', data: [
            'category_id'   => $category['category_id']
        ]);

        $this->data->head['title'] = $this->language->get('L_CATEGORY') . ' - ' . $category['category_name'];
    }
}