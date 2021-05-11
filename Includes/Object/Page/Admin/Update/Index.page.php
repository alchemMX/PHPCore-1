<?php

namespace Page\Admin\Update;

use Visualization\Field\Field;
use Visualization\Block\Block;
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

        // FIELD
        $field = new Field('Admin/Update');
        $field->disButtons();

        if (isset($GLOBALS['GITHUB'][0])) {

            $field->data(array_merge($GLOBALS['GITHUB'][0], [
                'pre-release' => $this->language->get($GLOBALS['GITHUB'][0]['prerelease'] == 1 ? 'L_UPDATE_TYPE_PRERELEASE' : 'L_UPDATE_TYPE_STABLE')
            ]));

            $field->object('available')->row('details')->setData('href', '$' . $GLOBALS['GITHUB'][0]['html_url']);
    
            if (empty($GLOBALS['GITHUB'][0]['name'])) {
                $field->row('name')->value($GLOBALS['GITHUB'][0]['tag_name']);
            }
        }

        if (!isset($GLOBALS['GITHUB'][0]) or $GLOBALS['GITHUB'][0]['tag_name'] == $this->system->settings->get('site.version')) {
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