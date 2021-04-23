<?php

namespace Model\Database;

use PDO;
use Model\Database\QueryCompiler;

/**
 * Database
 */
class Database
{
    /**
     * @var object $connect Connect to database
     */
    protected static object $connect;

    /**
     * @var int $id Last inserted id
     */
    protected int $id;

    /**
     * @var array $options Connection options
     */
    private static array $options = [
        PDO::ATTR_ERRMODE               => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES      => false,
        PDO::MYSQL_ATTR_INIT_COMMAND    => 'SET NAMES utf8mb4',
    ];
    
    /**
     * Constructor
     */
    protected function __construct()
    {
        try {
            // GET DATABASE ACCESS
            $access = json_decode(@file_get_contents(ROOT . '/Includes/Settings/.htdata.json'), true);

            // CONNECT
            self::$connect = @new PDO('mysql:dbname=' . $access['name'] . ';host=' . $access['host'] . ';port=' . $access['port'] . ';charset=utf8mb4', $access['user'], $access['pass'], self::$options);
            
            return true;

        } catch (\Exception $e) {
            throw new \Exception\System('Nepodařilo se připojit k databázi! ' . $e->getMessage());
        }
    }

    /**
     * Returns last inserted id
     *
     * @return int
     */
    public function lastInsertId()
    {
        return $this->id ?? 0;
    }
    
    /**
     * Executes compiled query
     *
     * @param  string $query
     * @param  array $param
     * 
     * @return object
     */
    protected function execute( string $query, array $param = [] )
    {
        try {
            $row = self::$connect->prepare($query);
            $row->execute((array)$param);

            return $row;

        } catch ( \Exception $e ) {
            throw new \Exception\System($e->getMessage() . '<br>' . $query);
        }
    }

    /**
     * Compiles query
     *
     * @param  string $tableName
     * @param  array $query
     * @param  string $type
     * @param int $id Item Id
     * 
     * @return string Compiled query
     */
    protected function compile( string $tableName, array $query, string $type, int $id = null )
    {
        $compiler = new QueryCompiler($tableName, $query, $type, $id);
        return $this->execute($compiler->getQuery(), $compiler->getParams());
    }
}