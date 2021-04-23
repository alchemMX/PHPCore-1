<?php

namespace Page\Admin\Menu\Show;

use Block\Page as BlockPage;
use Block\Button as BlockButton;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Button extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => int,
        'template' => 'Overall',
        'redirect' => '/admin/menu/',
        'permission' => 'admin.menu'
    ];

    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('menu')->active();
        
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Menu');
        $this->data->breadcrumb = $breadcrumb->getData();

        // BLOCK
        $page = new Blockpage();
        $button = new BlockButton();

        // PAGES
        $pages = $page->getAll();

        // BUTTON
        $button = $button->get($this->getID()) or $this->error();

        // FIELD
        $field = new Field('Admin/Menu/Button');
        $field->data($button);
        $field->object('button')
            ->title('L_MENU_BUTTON_EDIT')
            ->row('page_id')->fill($pages);
        $this->data->field = $field->getData();

        // EDIT BUTTON
        $this->process->form(type: 'Admin/Menu/Button/Edit', data: [
            'button_id' => $button['button_id']
        ]);

        $this->data->head['title'] = $this->language->get('L_MENU_BUTTON') . ' - ' . $button['button_name'];

    }
}