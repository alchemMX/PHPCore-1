<?php

namespace Visualization\Navbar;

/**
 * Navbar visualization
 */
class Navbar extends \Visualization\Visualization
{
    public \Model\Permission $perm;

    /**
     * Adds count notification
     *
     * @param string $count Count
     * @return object
     */
    public function notifiCount( $count )
    {
        if ($count > 0) {
            $this->obj->set->data('notifiCount', $count);
        }
        return $this;
    }

    /**
     * Adds icon notification
     *
     * @param string $unicode Icon unicode
     * @return object
     */
    public function notifiIcon( string $unicode )
    {
        $this->obj->set->data('notifiIcon', $unicode);
        return $this;
    }

    /**
     * Actives button in navbar
     *
     * @return object
     */
    public function active()
    {
        $this->obj->set->options('active', true);
        return $this;
    }
    
    /**
     * Executes code for every object
     *
     * @param  \Visualization\Visualization $visual
     * 
     * @return void|false
     */
    protected function each_clb( \Visualization\Visualization $visual )
    {
        if ($visual->obj->is->options('permission')) {
            if ($this->perm->has($visual->obj->get->options('permission')) === false) {
                return false;
            }
        }
    }
}
