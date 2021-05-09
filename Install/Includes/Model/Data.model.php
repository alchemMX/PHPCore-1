<?php

namespace Model;

/**
 * Data
 */
class Data 
{
    /**
     * @var array $data Page data
     */
    public array $data = [];

    /**
     * Adds data to page
     *
     * @param array $data
     * 
     * @return void
     */
    public function data( array $data )
    {
        $this->data = array_merge($this->data, $data);
    }
}
