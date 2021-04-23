<?php

namespace Page\Admin\Forum;

use Block\Admin\Forum;
use Block\Admin\Category;

use Visualization\Lists\Lists;
use Visualization\Breadcrumb\Breadcrumb;

class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
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
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // BLOCK
        $forum = new Forum();
        $category = new Category();

        // LIST
        $list = new Lists('Admin/Forum');

        // FOREACH CATEGORIES
        foreach ($category->getAll() as $_category) {

            $list->object('forum')->appTo($_category)->jumpTo()->fill($forum->getParent($_category['category_id']));
        }
        $this->data->list = $list->getData();
    }
}