<?php

namespace Page\Forum\Show;

use Block\Topic;
use Block\Forum;
use Block\Admin\Topic as AdminTopic;

use Model\Pagination;

use Visualization\Lists\Lists;
use Visualization\Panel\Panel;
use Visualization\Breadcrumb\Breadcrumb;


/**
 * Index forum page
 */
class Index extends \Page\Page
{    
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => int,
        'template' => 'Forum/View',
        'notification' => true
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // BLOCK
        $forum = new Forum();
        $topic = new Topic();

        if ($this->user->perm->has('admin.forum')) {
            $topic = new AdminTopic();
        }

        // GET FORUM
        $forum = $forum->get($this->getID()) or $this->error();

        if ($forum['topic_permission'] == 0) {
            $this->user->perm->disable('topic.create');
        }

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Forum/Show');
        $breadcrumb->object('category')->title('$' . $forum['category_name']);
        $this->data->breadcrumb = $breadcrumb->getData();

        // PANEL
        $panel = new Panel('Forum');

        // IF USER HAS PERMISSION TO CREATE TOPIC
        if ($this->user->perm->has('topic.create')) {

            // SHOW 'ADD TOPIC' BUTTON
            $panel->object('new')->show();
        }

        $this->data->panel = $panel->getData();

        // PAGINATION
        $pagination = new Pagination();
        $pagination->max(MAX_TOPICS);
        $pagination->url($this->getURL());
        $pagination->total($topic->getParentCount($this->getID()));
        $topic->pagination = $this->data->pagination = $pagination->getData();

        // LIST
        $list = new Lists('Topic');
        
        foreach ($topic->getParent($this->getID()) as $item) {
            
            if ((bool)$item['is_label'] === true) {

                $item['labels'] = $topic->getLabels($item['topic_id']);
            }

            $list->object('topic')->appTo($item)->jumpTo();

            if ($item['deleted_id']) {
                $list->disable();
            }
        }
        $this->data->list = $list->getData();

        // HEAD
        $this->data->head = [
            'title'         => $forum['forum_name'],
            'description'   => $forum['forum_description'],
        ];

    }
}