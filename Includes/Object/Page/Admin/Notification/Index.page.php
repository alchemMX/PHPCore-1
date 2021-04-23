<?php

namespace Page\Admin\Notification;

use Block\Admin\Notification;

use Visualization\Lists\Lists;
use Visualization\Breadcrumb\Breadcrumb;

class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
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
        
        // BLOCK
        $notification = new Notification();
        
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();
        
        // LIST
        $list = new Lists('Admin/Notification');
        $list->object('notification')->fill($notification->getAll());
        $this->data->list = $list->getData();
    }
}