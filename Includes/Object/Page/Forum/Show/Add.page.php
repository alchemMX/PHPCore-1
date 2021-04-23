<?php

namespace Page\Forum\Show;

use Block\Label;
use Block\Forum;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Add topic
 */
class Add extends \Page\Page
{    
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => int,
        'editor' => EDITOR_BIG,
        'template' => 'Forum/Topic/New',
        'permission' => 'topic.create'
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
        $label = new Label();

        // FORUM
        $forum = $forum->get($this->getID()) or $this->error();

        $forum['topic_permission'] == 1 or $this->redirect();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Forum/Show');
        $breadcrumb->object('category')->title('$' . $forum['category_name']);
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('Topic');
        $field->object('topic');

        if ($this->user->perm->has('topic.image')) {
            $field->row('topic_image')->show();
        }

        if ($this->user->perm->has('topic.label')) {
            $field->row('topic_labels')->show();
        }

        $field->row('topic_labels')->fill($labels = $label->getAll());
        $this->data->field = $field->getData();

        // CREATE TOPIC
        $this->process->form(type: 'Topic/Create', data: [
            'forum_id' => $this->getID(),
            'options' => [
                'input' => [
                    'topic_label' => array_column($labels, 'label_id')
                ]
            ]
        ]);

        // HEAD
        $this->data->head['description'] = $forum['forum_description'];
    }
}