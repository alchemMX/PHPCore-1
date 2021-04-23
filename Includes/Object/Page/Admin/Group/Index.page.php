<?php

namespace Page\Admin\Group;

use Block\Group;

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

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Group/Index');
        $this->data->field = $field->getData();

        // LIST
        $list = new Lists('Admin/Group');

        // GROUPS
        $groups = $group->getAll();

        $cache = $groups[0]['group_index'];
        foreach ($groups as $group) {

            $list->object('group')->appTo($group)->jumpTo();
            
            if ($this->user->perm->index($group['group_index']) === false) {

                $list->disable()
                    ->delButton([
                        'up',
                        'down',
                        'edit',
                        'delete',
                        'permission'
                    ]);
            }

            if ($cache >= $this->user->get('group_index')) {

                $list->delButton('up');
            }

            if ($group['group_id'] == $this->system->settings->get('default_group')) {

                $list->delButton('delete');
            }

            $cache = $group['group_index'];
        }

        $this->data->list = $list->getData();

        // CREATE NEW GROUP
        $this->process->form(type: 'Admin/Group/Create');
    }

}