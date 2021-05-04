<?php

namespace Page\Admin\Group;

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
        'template' => 'group/group',
        'redirect' => '/admin/group/',
        'permission' => 'admin.group'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    public function body()
    {
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Group');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Group');
        $field->object('group')->title('L_GROUP_NEW');
        $this->data->field = $field->getData();

        // CREATE NEW GROUP
        $this->process->form(type: 'Admin/Group/Create', data: [
            'options' => [
                'input' => [
                    'group_permission' => $this->user->perm->getPermissions()
                ]
            ]
        ]);
    }
}