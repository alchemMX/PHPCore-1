<?php

namespace Page\Admin\Menu\Add;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Dropdown extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'redirect' => '/admin/menu/',
        'permission' => 'admin.menu'
    ];

    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('menu')->active();
        
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Menu');
        $this->data->breadcrumb = $breadcrumb->getData();
        
        // FIELD
        $field = new Field('Admin/Menu/Dropdown');
        $field->object('dropdown')->title('L_MENU_DROPDOWN_NEW');
        $this->data->field = $field->getData();

        // CREATE NEW DROPDOWN
        $this->process->form('Admin/Menu/Dropdown/Create');
    }
}