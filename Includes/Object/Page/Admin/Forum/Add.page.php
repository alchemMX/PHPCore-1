<?php

namespace Page\Admin\Forum;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Add extends \Page\Page
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

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Forum');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Forum/Forum');
        $field->object('forum')->title('L_FORUM_NEW');
        $this->data->field = $field->getData();

        // CREATE FORUM
        $this->process->form(type: 'Admin/Forum/Create', data: [
            'category_id'   => $this->getID()
        ]);
    }
}