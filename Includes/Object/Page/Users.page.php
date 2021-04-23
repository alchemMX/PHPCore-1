<?php

namespace Page;

use Block\User;

use Model\Pagination;

use Visualization\Lists\Lists;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Users page
 */
class Users extends Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Users',
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // BLOCK
        $user = new User();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Index');
        $this->data->breadcrumb = $breadcrumb->getData();

        // PAGINATION
        $pagination = new Pagination();
        $pagination->max(MAX_USERS);
        $pagination->url($this->getURL());
        $pagination->total($user->getAllCount());
        $user->pagination = $this->data->pagination = $pagination->getData();

        // LIST
        $list = new Lists('Users');
        $list->object('users')->fill($user->getAll());
        $this->data->list = $list->getData();
    }
}