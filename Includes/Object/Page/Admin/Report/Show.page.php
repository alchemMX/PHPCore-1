<?php

namespace Page\Admin\Report;

use Block\Report;
use Block\Admin\Post;
use Block\Admin\Topic;
use Block\Admin\ProfilePost;
use Block\Admin\ProfilePostComment;

use Model\Pagination;

use Visualization\Lists\Lists;
use Visualization\Field\Field;
use Visualization\Block\Block;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Show
 */
class Show extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected array $settings = [
        'id' => int,
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
        // BLOCK
        $report = new Report();

        // REPORT DATA
        $data = $report->get($this->getID());

        // PAGINATION
        $pagination = new Pagination();
        $pagination->max(MAX_REPORTED_TOPIC);
        $pagination->total($report->getAllReasonsCount($this->getID()));
        $pagination->url($this->getURL());
        $report->pagination = $this->data->pagination = $pagination->getData();

        // FIELD
        $field = new Field('Admin/Report');

        // ASSIGN DATA BASED ON TYPE
        switch ($data['report_type']) {
            case 'Post': 
                $content = (new Post)->get($data['report_type_id']);

                $field->object('show')->row('post_id')->show();
            break;
            case 'Topic': 
                $content = (new Topic)->get($data['report_type_id']);

                $field->object('show')->row('topic_id')->show();
            break;
            case 'ProfilePost': 
                $content = (new ProfilePost)->get($data['report_type_id']);

                $field->object('show')->row('profile_post_id')->show();
            break;
            case 'ProfilePostComment': 
                $content = (new ProfilePostComment)->get($data['report_type_id']);
                
                $field->object('show')->row('profile_post_comment_id')->show();
            break;
        }

        // NAVBAR
        $this->navbar->object('forum')->row('reported')->active()->option(strtolower($data['report_type']))->active();

        if (empty($content)) {
            redirect('/admin/report/');
        }

        $data = array_merge($content, $data);
        
        // URL TO REPORTED CONTENT
        $field->object('show')->row('show')->setData('href', '$' . $this->build->url->{lcfirst($data['report_type'])}($data));

        $field->data($data);

        // IF CONTENT OR HIS PARENT IS IN TRASH
        foreach (['post_deleted_id', 'topic_deleted_id', 'profile_post_deleted_id', 'profile_post_comment_deleted_id'] as $id) {
            if (isset($data[$id]) and !empty($data[$id])) {
                $field->object('show')->row($id)->show()->setData('href', '$/admin/deleted/show/' . $data[$id]);
            }
        }

        if ($data['report_status'] == 0) {
            $field->object('show')->row('submit')->show();
        }

        $field->disButtons();
        $this->data->field = $field->getData();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Report/' . $data['report_type']);
        $this->data->breadcrumb = $breadcrumb->getData();

        // BLOCK
        $block = new Block('Admin/Report/Show');
        $block
            ->object('type')->value($this->language->get('L_CONTENT_LIST')[$data['report_type']])
            ->object('reasons')->value($report->getReasonsCount($this->getID()))
            ->object('first_report')->value($this->build->date->long($data['report_created']))
            ->object('status')->value($data['report_status'] == 1 ? $this->language->get('L_REPORT_STATUS_CLOSED') : $this->language->get('L_REPORT_STATUS_PENDING'));
        $this->data->block = $block->getData();

        // LIST
        $list = new Lists('Admin/Report/Show');
        $list->object('reasons')->fill($report->getAllReasons($this->getID()));
        $this->data->list = $list->getData();

        // IF REPORT IS NOT CLOSED
        if ($data['report_status'] == 0) {
            
            // CLOSE REPORT
            $this->process->form(type: 'Admin/Report/Close', data: [
                'report_id' => $this->getID(),
                'report_type' => $data['report_type'],
                'report_type_id' => $data['report_type_id']
            ]);
        }
    }
}