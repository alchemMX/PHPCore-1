<?php

namespace Process;

use Model\System;
use Model\Database;

use Process\ProcessData;

/**
 * ProcessExtend
 */
class ProcessExtend
{    
    /**
     * @var \Model\Database $db Database
     */
    public \Model\Database $db;

    /**
     * @var \Model\System $system System model
     */
    protected \Model\System $system;

    /**
     * @var \Process\ProcessData $data ProcessData
     */
    protected \Process\ProcessData $data;

    /**
     * @var \Process\ProcessCheck $check ProcessCheck
     */
    protected \Process\ProcessCheck $check;
        
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->db = new Database();
        $this->check = new ProcessCheck();
        $this->system = new System();
    }
    
    /**
     * Loads data to process
     *
     * @param  array $data The data
     * 
     * @return void
     */
    public function data( array $data )
    {
        $this->data = new ProcessData($data);
    }
}