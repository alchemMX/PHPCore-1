<?php

namespace Page\Admin\Group;

use Block\Group;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Show
 */
class Show extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'id' => int,
        'template' => 'Overall',
        'redirect' => '/admin/group/',
        'permission' => 'admin.group'
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('group')->active();
        
        // BLOCK
        $group = new Group();

        // GROUP
        $group = $group->get($this->getID()) or $this->error();

        // IF LOGGED USER DOENSN'T HAVE PERMISISON TO EDIT THIS GROUP 
        $this->user->perm->index($group['group_index']) or $this->redirect();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Group');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Group/Group');
        $field->data($group);


        if ($this->system->settings->get('default_group') != $group['group_id']) {

            $field->object('group')->row('is_default')->show();
        }

        $this->data->field = $field->getData();

        // EDIT GROUP
        $this->process->form(type: 'Admin/Group/Edit', data: [
            'group_id' => $group['group_id'],
            'options' => [
                'input' => [
                    'group_permission' => $this->user->perm->getPermissions()
                ]
            ]
        ]);

        // PAGE TITLE
        $this->data->head['title'] = $this->language->get('L_GROUP') . ' - ' . $group['group_name'];
    }
}