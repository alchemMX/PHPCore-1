<?php

namespace Visualization\Navbar;

/**
 * Navbar
 */
class Navbar extends \Visualization\Visualization
{
    /**
     * @var \Model\Permission $perm Permission
     */
    public \Model\Permission $perm;

    /**
     * Adds count notification
     *
     * @param string $count Count
     * 
     * @return $this
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
     * 
     * @return $this
     */
    public function notifiIcon( string $unicode )
    {
        $this->obj->set->data('notifiIcon', $unicode);
        return $this;
    }

    /**
     * Actives button in navbar
     *
     * @return $this
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
