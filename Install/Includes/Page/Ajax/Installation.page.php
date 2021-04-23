<?php

namespace Page\Ajax;

use Model\Database;

/**
 * Installation page
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
        try {
            $db = new Database();

            $db->connect->exec(file_get_contents(ROOT . '/Install/Query.sql'));

            echo json_encode([
                'status' => 'ok',
                'title' => self::$language['L_INSTALL_SUCCESS'],
                'button' => self::$language['L_CONTINUE']
            ]);

            $this->system->install([
                'db' => true,
                'page' => 4,
            ]);
        
        } catch (\PDOException $e) {
            echo json_encode([
                'status' => 'error',
                'error' => $e->getMessage(),
                'title' => self::$language['L_INSTALL_ERROR'],
                'button' => self::$language['L_RETRY']
            ]);
        }
    
    
        exit();
    }
}