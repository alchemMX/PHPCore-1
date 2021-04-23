<?php

namespace Page\Admin\Category;

use Block\Group;
use Block\Admin\Category;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Permission extends \Page\Page
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
        $group = new Group();
        $category = new Category();

        // GET FORUM DATA
        $_category = $category->get($this->getID()) or $this->error();

        // SEE PERMISSION
        $_category['see'] = $category->getSee($this->getID());

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Forum');
        $this->data->breadcrumb = $breadcrumb->getData(); 

        // FIELD
        $field = new Field('Admin/Category/Permission');
        $field->data($_category);
        $field->object('groups')->fill(array_merge($group->getAll(), [0 => [
            'group_id' => 0,
            'group_name' => $this->language->get('L_GROUP_VISITOR'),
            'group_color' => '#4e4e4e',
            'group_class_name' => 'visitor'
        ]]));
        $this->data->field = $field->getData();

        // EDIT FORUM PERMISSION
        $this->process->form(type: 'Admin/Category/Permission', data: [
            'category_id' => $this->getID()
        ]);
    }
}