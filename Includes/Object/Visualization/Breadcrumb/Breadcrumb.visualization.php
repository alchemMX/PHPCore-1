<?php

namespace Visualization\Breadcrumb;

/**
 * Breadcrumb visualization
 */
class Breadcrumb extends \Visualization\Visualization 
{    
    /**
     * Adds href value to data
     *
     * @param  string $href
     * 
     * @return void
     */
    public function href( string $href )
    {
        $this->obj->set->data('href', $href);
    }
}