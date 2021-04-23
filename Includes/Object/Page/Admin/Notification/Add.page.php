<?php

namespace Page\Admin\Notification;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Add extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'redirect' => '/admin/notification/',
        'permission' => 'admin.notification'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('notification')->active();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Notification');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Admin/Notification');
        $field->object('notification')->title('L_NOTIFICATION_NEW');
        $this->data->field = $field->getData();

        // CREATE NEW NOTIFICATION
        $this->process->form('Admin/Notification/Create');
    }
}