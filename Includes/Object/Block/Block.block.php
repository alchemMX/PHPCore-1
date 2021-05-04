<?php

namespace Block;

use Model\Database\Query;

/**
 * Block
 */
abstract class Block {
    
    /**
     * @var array Pagination data
     */
    public array $pagination;

    /**
     * @var \Block\BlockJoin $join BlockJoin
     */
    protected \Block\BlockJoin $join;

    /**
     * @var \Block\BlockSelect $select BlockSelect
     */
    protected \Block\BlockSelect $select;

    /**
     * @var \Model\Database\Query $db Database
     */
    protected \Model\Database\Query $db;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = new Query();
        $this->join = new BlockJoin();
        $this->select = new BlockSelect();
    }
}