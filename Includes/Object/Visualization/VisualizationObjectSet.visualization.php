<?php

namespace Visualization;

/**
 * VisualizationObjectSet
 */
class VisualizationObjectSet
{
    /**
     * @var object $delete VisualiaztionObjectDelete
     */
    public VisualizationObjectDelete $delete;

    /**
     * Constructor
     *
     * @param  array $object
     */
    public function __construct( array $object )
    {
        $this->delete = new VisualizationObjectDelete($object);
    }

    /**
     * Set value to object
     *
     * @param  string $key
     * @param  mixed $value
     * 
     * @return void
     */
    public function set( string $key, mixed $value )
    {
        $this->delete->object[$key] = $value;
    }
    
    /**
     * Set value to data
     *
     * @param  string $key
     * @param  mixed $value
     * 
     * @return void
     */
    public function data( string $key, mixed $value )
    {
        $this->delete->object['data'][$key] = $value;
    }

    /**
     * Set value to options
     *
     * @param  string $key
     * @param  mixed $value
     * 
     * @return void
     */
    public function options( string $key, mixed $value )
    {
        $this->delete->object['options'][$key] = $value;
    }

    /**
     * Set path to template
     *
     * @param  string $key
     * @param  mixed $value
     * 
     * @return void
     */
    public function template( string $key, mixed $value )
    {
        $this->delete->object['options']['template'][$key] = $value;
    }

    /**
     * Set data to button
     *
     * @param  string $key
     * @param  mixed $value
     * 
     * @return void
     */
    public function button( string $key, mixed $value )
    {
        $this->delete->object['data']['button'][$key] = $value;
    }

    /**
     * Adds row to body
     *
     * @param  string $key
     * @param  array $value
     * 
     * @return void
     */
    public function body( string $key, array $value )
    {
        $this->delete->object['body'][$key] = $value;
    }

    /**
     * Set data to notice
     *
     * @param  string $key
     * @param  mixed $value
     * 
     * @return void
     */
    public function notice( string $key, mixed $value )
    {
        $this->delete->object['data']['notice'][$key] = $value;
    }
}