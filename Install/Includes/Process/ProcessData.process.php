<?php

namespace Process;

use Exception;

/**
 * Process
 */
class ProcessData
{
    /**
     * @var array $data Process data
     */
    private $data;

    /**
     * Constructor
     *
     * @param  array $data
     * @return void
     */
    public function __construct( array $data )
    {
        $this->data = $data;
    }
    
    /**
     * Returns value from data
     *
     * @param  string $input
     * @return mixed
     */
    public function get( string $input )
    {
        if (array_key_exists($input, (array)$this->data) === false) {
            throw new Exception(get_class($this) . ' zkouší získat neexistující proměnnou \'' . $input . '\'');
        }

        return $this->data[$input];
    }

    /**
     * Checks if given data input is checked
     *
     * @return bool
     */
    public function is( string $string )
    {
        return (int)$this->data[$string] === (int)1 ? true : false;
    }
    
    /**
     * Sets value
     *
     * @param  string $valueName
     * @param  mixed $value
     * @return void
     */
    public function set( string $valueName, $value )
    {
        $this->data[$valueName] = $value;
    }

    /**
     * Returns data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }
}