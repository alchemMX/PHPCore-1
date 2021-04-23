<?php

namespace Visualization;

/**
 * VisualizationObjectIs
 */
class VisualizationObjectIs
{
    /**
     * @var array $object Object
     */
    protected array $object = [];

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
     * Returns value from data
     *
     * @param  string $key
     * 
     * @return bool
     */
    public function data( string $key = null )
    {
        return isset($this->object['data'][$key]);
    }

    /**
     * Returns value from options
     *
     * @param  string $key
     * 
     * @return bool
     */
    public function options( string $key )
    {
        return isset($this->object['options'][$key]);
    }

    /**
     * Returns template path
     *
     * @param  string $key
     * 
     * @return bool
     */
    public function template( string $key )
    {
        return isset($this->object['options']['template'][$key]);
    }

    /**
     * Returns cihld row convert data
     * 
     * @return bool
     */
    public function convert()
    {
        return isset($this->object['body']['default']['data']['convert']);
    }

    /**
     * Returns button data
     *
     * @param  string $key
     * 
     * @return bool
     */
    public function button( string $key = null)
    {
        if (is_null($key)) {
            return isset($this->object['data']['button']);
        }

        return isset($this->object['data']['button'][$key]);
    }

    /**
     * Returns object body or row from body
     * 
     * @param string $key
     * 
     * @return bool
     */
    public function body( string $key = null )
    {
        if (is_null($key)) {
            return isset($this->object['body']);
        }

        return isset($this->object['body'][$key]);
    }
}