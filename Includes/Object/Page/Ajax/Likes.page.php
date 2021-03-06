<?php

namespace Page\Ajax;

use Block\Post;
use Block\Topic;

use Model\Get;

/**
 * Likes
 */
class Likes extends \Page\Page
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
        $get->get('process') or exit();

        $block = match (array_shift(explode('/', $get->get('process')))) {
            'Post' => new Post(),
            'Topic' => new Topic()
        };
        $content = '';
        foreach ($block->getLikesAll($get->get('id')) as $like) {
            $content .= $this->build->user->info($like);
        }

        $this->data->data([
            'status' => 'ok',
            'windowTitle' => $this->language->get('L_LIKE_LIST'),
            'windowContent' => $content
        ]);
    }
}