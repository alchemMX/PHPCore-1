<?php
namespace Page\Admin\Menu;

use Block\Button;
use Block\ButtonSub;

use Visualization\Lists\Lists;
use Visualization\Breadcrumb\Breadcrumb;

class Index extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'template' => 'Overall',
        'permission' => 'admin.menu'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('menu')->active();
        
        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/Admin');
        $this->data->breadcrumb = $breadcrumb->getData();

        // BLOCK
        $button = new Button();
        $buttonSub = new ButtonSub();

        // LIST
        $list = new Lists('Admin/Menu');

        foreach ($button->getAll() as $item) {

            $list->object('button')->appTo($item)->jumpTo();
            if ((bool)$item['is_dropdown'] === true) {
                $list->fill($buttonSub->getParent($item['button_id']))->sync();
            }
        }
        $this->data->list = $list->getData();
    }
}