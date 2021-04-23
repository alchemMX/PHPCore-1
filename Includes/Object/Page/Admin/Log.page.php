<?php

namespace Page\Admin;

use Block\Log as LogBlock;

use Model\Pagination;

use Visualization\Lists\Lists;
use Visualization\Breadcrumb\Breadcrumb;

class Log extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'permission' => 'admin.?'
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('other')->row('log')->active();

        // BLOCK
        $log = new LogBlock();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // PAGINATION
        $pagination = new Pagination();
        $pagination->max(20);
        $pagination->total($log->getAllCount());
        $pagination->url($this->getURL());
        $log->pagination = $this->data->pagination = $pagination->getData();

        // LIST
        $list = new Lists('Admin/Log');
        $list->object('log')->fill($log->getAll());
        $this->data->list = $list->getData();
    }
}