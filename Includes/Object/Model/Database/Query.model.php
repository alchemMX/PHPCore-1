<?php

namespace Model\Database;

/**
 * Query
 */
class Query extends Database {
    
    /**
     * Constructor
     */
    public function __construct()
    {
        if (empty(self::$connect)) {
            parent::__construct();
        }

        return $this;
    }

    /**
     * Executes query
     *
     * @param  string $query
     * @param  array $parameters
     * @param  int $catchType
     * 
     * @return array
     */
    public function query( string $query, array $parameters = [], int $catchType = SINGLE)
    {
        $result = $this->execute($query, $parameters);
        if ($catchType === ROWS) return $result->fetchAll();

        return $result->fetch();
    }
    
    /**
     * Update query
     *
     * @param  string $tableName
     * @param  array $query
     * @param int $id Item id
     * 
     * @return void
     */
    public function update( string $tableName, array $query, int $id = null )
    {
        $this->compile($tableName, $query, 'update', $id);
    }

    /**
     * Insert query
     *
     * @param  string $tableName
     * @param  array $query
     * 
     * @return void
     */
    public function insert( string $tableName, array $query )
    {
        $this->compile($tableName, $query, 'insert');
        $this->id = self::$connect->lastInsertId();
    }
}