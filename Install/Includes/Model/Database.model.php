<?php

namespace Model;

class Database
{

    public $connect;

    public function __construct()
    {
        $allow = json_decode(file_get_contents(ROOT . '/Install/Includes/Settings.json'), true);
        if ((bool)$allow['db'] === false) return false;

        $access = json_decode(file_get_contents(ROOT . '/Includes/Settings/.htdata.json'), true);

        if ($access['name'] && $access['host'] && $access['user'] && $access['pass']) {

            // CONNECT
            $this->connect = @new \PDO('mysql:dbname=' . $access['name'] . ';host=' . $access['host'] . ';port=' . $access['port'] . ';charset=utf8mb4', $access['user'], $access['pass'], [
                \PDO::ATTR_ERRMODE               => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_EMULATE_PREPARES      => false,
                \PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8',
            ]);
            $this->query('SET NAMES utf8');
        }

    }
    
    public function query($query, $param = [])
    {
        $row = $this->connect->prepare($query);
        $row->execute($param);
    }

    public function get($query, $param = [])
    {
        $row = $this->connect->prepare($query);
        $row->execute($param);

        return $row->fetch();
    }

}