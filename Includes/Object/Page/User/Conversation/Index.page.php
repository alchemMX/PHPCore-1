<?php

namespace Page\User\Conversation;

use Block\Conversation;

use Model\Pagination;

use Visualization\Lists\Lists;
use Visualization\Panel\Panel;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Index
 */
class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'template' => 'User/Conversation/Index',
        'loggedIn' => true
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    { 
        // BLOCK
        $conversation = new Conversation();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('User/Index');
        $this->data->breadcrumb = $breadcrumb->getData();

        // PANEL
        $panel = new Panel('Conversation_list');
        $this->data->panel = $panel->getData();

        // PAGINATION
        $pagination = new Pagination();
        $pagination->max(MAX_PRIVATE_MESSAGES);
        $pagination->total($conversation->getAllCount());
        $pagination->url($this->getURL());
        $conversation->pagination = $this->data->pagination = $pagination->getData();

        // LIST
        $list = new Lists('Conversation');

        foreach ($conversation->getAll() as $item) {

            $list->object('conversation')->appTo($item)->jumpTo();

            if (in_array($item['conversation_id'], $this->user->get('unread'))) {
                $list->select();
            }
        }
        $this->data->list = $list->getData();
    }
}