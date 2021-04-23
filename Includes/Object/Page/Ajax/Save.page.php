<?php

namespace Page\Ajax;

use Model\Get;

/**
 * Ajax save page
 */
class Save extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'loggedIn' => true
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    public function body()
    {
        $get = new Get();

        if (!$get->get('id') or !$get->get('type')) {
            exit();
        }

        switch ($get->get('type')) {
            case 'post': 
                if ($this->user->perm->has('post.edit') === false) {
                    exit();
                }
            break;
            case 'topic': 
                if ($this->user->perm->has('topic.edit') === false) {
                    exit();
                }
            break;
            case 'profile_post':
            case 'profile_post_comment':
                if ($this->user->perm->has('profilepost.edit') === false) {
                    exit();
                }
            break;
        }

        $this->process->direct();

        $type = str_to_upper($get->get('type'));

        if ($this->process->form(type: $type . '/Edit', data: [$get->get('type') . '_id' => $get->get('id')])) {

            $this->data->data([
                'button' => $this->file('/Blocks/Block/Buttons/Edit'),
                'status' => 'ok'
            ]);
        }
    }
}