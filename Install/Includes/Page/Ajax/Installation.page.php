<?php

namespace Page\Ajax;

use Model\Database;

/**
 * Installation
 */
class Installation extends \Page\Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $db = new Database();

        $db->connect->exec(file_get_contents(ROOT . '/Install/Query.sql'));

        echo json_encode([
            'status' => 'ok',
            'title' => $this->language->get('L_INSTALL_SUCCESS'),
            'button' => $this->language->get('L_CONTINUE')
        ]);

        $this->system->install([
            'db' => true,
            'page' => 4,
        ]);
    
        exit();
    }
}