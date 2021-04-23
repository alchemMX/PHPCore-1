<?php

namespace Visualization;

/**
 * VisualizationObjectGet
 */
class VisualizationObjectGet
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
     * @return mixed
     */
    public function data( string $key = null )
    {
        if (is_null($key)) {
            return $this->object['data'] ?? [];
        }

        return $this->object['data'][$key] ?? '';
    }

    /**
     * Returns value from options
     *
     * @param  string $key
     * 
     * @return mixed
     */
    public function options( string $key )
    {
        return $this->object['options'][$key] ?? '';
    }

    /**
     * Returns template path
     *
     * @param  string $key
     * 
     * @return mixed
     */
    public function template( string $key )
    {
        return $this->object['options']['template'][$key] ?? '';
    }

    /**
     * Returns cihld row convert data
     * 
     * @return array
     */
    public function convert()
    {
        return $this->object['body']['default']['data']['convert'] ?? [];
    }

    /**
     * Returns button data
     *
     * @param  string $key
     * 
     * @return mixed
     */
    public function button( string $key = null)
    {
        if (is_null($key)) {
            return $this->object['data']['button'] ?? [];
        }

        return $this->object['data']['button'][$key] ?? '';
    }

    /**
     * Returns object body or row from body
     * 
     * @param string $key
     * 
     * @return array
     */
    public function body( string $key = null )
    {
        if (is_null($key)) {
            return $this->object['body'] ?? [];
        }

        return $this->object['body'][$key] ?? [];
    }
}