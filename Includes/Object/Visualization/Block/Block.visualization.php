<?php

namespace Visualization\Block;

/**
 * Block visualization
 */
class Block extends \Visualization\Visualization
{
    /**
     * Selects current object
     *
     * @return self
     */
    public function select()
    {   
        $this->obj->set->options('selected', true);
        return $this;
    }

    /**
     * Opens current object
     *
     * @return self
     */
    public function open()
    {
        $this->obj->set->options('closed', false);
        return $this;
    }

    /**
     * Closes current object
     *
     * @return self
     */
    public function close()
    {
        $this->obj->set->options('closed', true);
        return $this;
    }

    /**
     * Shows notice
     *
     * @return self
     */
    public function notice( string $notice )
    {
        $this->obj->set->notice($notice, ['hide' => false]);
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
        if ($visual->obj->get->data('notice')) {

            foreach ($visual->obj->get->data('notice') as $noticeName => $notice) {
                
                if ($notice['hide'] === true) {
                    $visual->obj->set->notice($noticeName, false);
                } else {
                    $visual->obj->set->notice($noticeName, $this->template->require('/Blocks/Block/Notice/' . ucfirst($noticeName)));
                }
            }
        }

        if ($visual->obj->get->data('button')) {
            foreach (array_keys((array)$visual->obj->get->data('button')) as $btn) {

                // IF LOGGED USER ID IS SAME AS OBJECT USER ID
                if ($visual->obj->get->data('user_id') == LOGGED_USER_ID) {

                    // DELETE 'LIKE' AND 'UNLIKE' BUTTONS
                    if (in_array($btn, ['like', 'unlike'])) {
                        $visual->obj->set->delete->button($btn);
                        continue;
                    }
                } else {

                    // DELETE 'EDIT' BUTTON
                    $visual->obj->set->delete->button('edit');

                    switch ($btn) {
    
                        case 'like':
                        
                            // DELETE 'LIKE' BUTTON IF LOGGED USER ALREADY LIKED THIS OBJECT
                            if (in_array(LOGGED_USER_ID, array_column((array)$visual->obj->get->data('likes'), 'user_id'))) {
                                $visual->obj->set->delete->button($btn);
                                continue 2;
                            } 
                        break;
    
                        case 'unlike':

                            // DELETE 'UNLIKE' BUTTON IF LOGGED USER DOESN'T LIKED THIS OBJECT
                            if (!in_array(LOGGED_USER_ID, array_column((array)$visual->obj->get->data('likes'), 'user_id'))) {
                                $visual->obj->set->delete->button($btn);
                                continue 2;
                            }
                        break;
                    }
                }
                
                // ASSIGN BUTTON TEMPLATE
                $visual->obj->set->button($btn, $visual->template->require('/Blocks/Block/Buttons/' . ucfirst($btn)));
            }
        }
    }
}
