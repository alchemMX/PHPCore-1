<?php

namespace Page\Ajax;

use Block\ProfilePostComment;
use Block\Admin\ProfilePostComment as AdminProfilePostComment;

use Model\Get;

use Visualization\Block\Block;

/**
 * Comments
 */
class Comments extends \Page\Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $get = new Get();

        $get->get('id') or exit();

        $profilePostComment = new ProfilePostComment();

        if ($this->user->perm->has('admin.forum')) {
            $profilePostComment = new AdminProfilePostComment();
        }

        $data = $profilePostComment->getAfterNext($get->get('id'));

        $block = new Block('ProfilePostComment');
        $block->object('profilepostcomment')->fill($data);

        $blocks = '';
        foreach ($block->getData()['body']['profilepostcomment']['body'] as $row) {
            $blocks .= $this->file('/Blocks/Block/ProfilePostComment.phtml', [
                'variable' => '$row',
                'data' => $row
            ]);
        }

        $this->data->data([
            'content' => $blocks,
            'status' => 'ok'
        ], JSON_UNESCAPED_UNICODE);
    }
}