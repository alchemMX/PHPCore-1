<?php

namespace Page\User\Pm;

use Block\Pm;

use Model\Pagination;

use Visualization\Lists\Lists;
use Visualization\Panel\Panel;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Private messages
 */
class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'User/Pm/Index',
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
        $pm = new Pm();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('User/Index');
        $this->data->breadcrumb = $breadcrumb->getData();

        // PANEL
        $panel = new Panel('Pm_list');
        $this->data->panel = $panel->getData();

        // PAGINATION
        $pagination = new Pagination();
        $pagination->max(MAX_PRIVATE_MESSAGES);
        $pagination->total($pm->getAllCount());
        $pagination->url($this->getURL());
        $pm->pagination = $this->data->pagination = $pagination->getData();

        // LIST
        $list = new Lists('Pm');

        // FOREACH PRIVATE MESSAGES
        foreach ($pm->getAll() as $item) {

            // GET USERS DATA
            $item['users'] = $pm->getRecipients($item['pm_id']);

            $list->object('pm')->appTo($item);
        }
        $this->data->list = $list->getData();
    }
}