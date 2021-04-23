<?php

namespace Page\Admin\User;

use Block\User;
use Block\Group;

use Visualization\Field\Field;
use Visualization\Breadcrumb\Breadcrumb;

class Show extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'id' => int,
        'template' => 'Overall',
        'redirect' => '/admin/user/',
        'permission' => 'admin.user'
    ];

    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        // NAVBAR
        $this->navbar->object('settings')->row('user')->active();
        
        // BLOCK
        $userB = new User();
        $group = new Group();

        // BREADCRUMB
        $breadcrumb = new Breadcrumb('Admin/User');
        $this->data->breadcrumb = $breadcrumb->getData();

        // USER
        $user = $userB->get($this->getID()) or $this->error();
        $user['code'] = $user['verify_code'];

        // IF LOGGED USER HAS PERMISSION TO EDIT THIS USER
        $this->user->perm->compare(
            index: $user['group_index'],
            admin: $user['is_admin']
        ) or $this->redirect();

        // FIELD
        $field = new Field('Admin/User/User');
        $field->data($user);
        $field->object('user')->row('group_id')->fill($groups = $group->getLess());

        // IF USER DOESN'T HAVE ACTIVATED ACCOUNT
        if ($user['code']) {

            $field->row('activate')->show();
        }

        // IF LOGGED USER IS ADMIN
        if ($this->user->admin === true) {

            $field->row('promote')->show();
        }

        if (LOGGED_USER_ID == $user['user_id']) {

            $field->row('delete')->hide();
        }

        // SHOW DELETE SIGNATURE
        if ($user['user_signature']) {

            $field->row('delete_signature')->show();
        }

        // SHOW DELETE PROFILE IMAGE
        if (!in_array($user['user_profile_image'], PROFILE_IMAGES_COLORS)) {

            $field->row('delete_profile_image')->show();
        }

        // SHOW DELETE HEADER IMAGE
        if ($user['user_header_image']) {

            $field->row('delete_header_image')->show();
        }

        // IF USER IS ADMIN
        if ($user['is_admin'] == 1) {
            
            $field->row('promote')->hide();
        }

        $this->data->field = $field->getData();

        // EDIT USER
        $this->process->form(type: 'Admin/User/Edit', data: [
            'user_id' => $user['user_id'],
            'options' => [
                'input' => [
                    'group_id' => array_column($groups, 'group_id')
                ]
            ]
        ]);

        if ($user['code']) {
            // ACTIVATE USER
            $this->process->call(type: 'Admin/User/Activate', data: [
                'user_id' => $user['user_id'],
                'options' => [
                    'on' => [$this->getOperation() => 'activate']
                ]
            ]);
        }

        $this->data->head['title'] = $this->language->get('L_USER') . ' - ' . $user['user_name'];
    }
}