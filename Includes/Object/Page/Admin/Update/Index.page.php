<?php

namespace Page\Admin\Update;

use Visualization\Field\Field;
use Visualization\Block\Block;
use Visualization\Breadcrumb\Breadcrumb;

class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'permission' => 'admin.settings'
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('other')->row('update')->active();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // CURRENT VERSION DETAILS
        $githubAPI = json_decode(@file_get_contents(GITHUB, false, CONTEXT), true);

        // FIELD
        $field = new Field('Admin/Update');
        $field->disButtons();

        if (isset($githubAPI[0])) {

            $field->data(array_merge($githubAPI[0], [
                'pre-release' => $this->language->get($githubAPI[0]['prerelease'] == 1 ? 'L_UPDATE_TYPE_PRERELEASE' : 'L_UPDATE_TYPE_STABLE')
            ]));

            $field->object('available')->row('details')->setData('href', '$' . $githubAPI[0]['html_url']);
    
            if (empty($githubAPI[0]['name'])) {
                $field->row('name')->value($githubAPI[0]['tag_name']);
            }
        }

        if (!isset($githubAPI[0]) or $githubAPI[0]['tag_name'] == $this->system->settings->get('site.version')) {
            $field->object('latest')->show();
        } else {
            $field->object('available')->show();
        }

        $this->data->field = $field->getData();

        // BLOCK
        $block = new Block('Admin/Update');
        $block
            ->object('version')->value($this->system->settings->get('site.version'))
            ->object('last_updated')->value($this->build->date->short($this->system->settings->get('site.updated')));
        $this->data->block = $block->getData();
    }
}