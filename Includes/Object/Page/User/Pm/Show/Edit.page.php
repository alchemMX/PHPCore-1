<?php

namespace Page\User\Pm\Show;

use Block\Pm;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

/**
 * Show pm page
 */
class Edit extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => int,
        'editor' => EDITOR_BIG,
        'template' => 'User/Pm/Edit',
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

        // PM DATA
        $pm = $pm->get($this->getID()) or $this->error();

        // IF THIS PM IS NOT MINE
        if ($pm['user_id'] != LOGGED_USER_ID) redirect('/user/pm/');

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('User/Pm');
        $this->data->breadcrumb = $breadcrumb->getData();

        // FIELD
        $field = new Field('User/Pm');
        $field->data($pm);
        $this->data->field = $field->getData();

        // EDIT PRIVATE MESSAGE
        $this->process->form(type: 'Pm/Edit', data: [
            'pm_id' => $pm['pm_id']
        ]);

        // HEAD
        $this->data->head['title'] = $pm['pm_subject'];
    }
}