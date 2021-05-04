<?php

namespace Visualization;

/**
 * VisualizationObjectDelete
 */
class VisualizationObjectDelete
{
    /**
     * @var array $object Object
     */
    public array $object = [];

    /**
     * Constructor
     *
     * @param  array $object
     */
    public function __construct( array $object )
    {
        $this->object = $object;
    }

    /**
     * Deletes value from data
     *
     * @param  string $key
     * 
     * @return void
     */
    public function data( string $key )
    {
        unset($this->object['data'][$key]);
    }

    /**
     * Deletes value from options
     *
     * @param  string $key
     * 
     * @return void
     */
    public function options( string $key )
    {
        unset($this->object['options'][$key]);
    }

    /**
     * Deletes button
     *
     * @param  string $key If null - deletes all buttons
     * 
     * @return void
     */
    public function button( string $key = null )
    {
        if (is_null($key)) {
            unset($this->object['data']['button']);
            return;
        }
        unset($this->object['data']['button'][$key]);
    }

    /**
     * Deletes object from body
     *
     * @param  string $key
     * 
     * @return void
     */
    public function body( string $key )
    {
        unset($this->object['body'][$key]);
    }

    /**
     * Deletes object
     * 
     * @return void
     */
    public function delete()
    {
        $this->object = [];
    }
}