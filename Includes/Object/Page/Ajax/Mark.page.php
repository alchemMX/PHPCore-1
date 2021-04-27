<?php

namespace Page\Ajax;

/**
 * Mark
 */
class Mark extends \Page\Page
{
    /**
     * @var array $settings Page settings
     */
    protected $settings = [
        'loggedIn' => true
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        $this->process->direct();
        
        if ($this->process->call(type: 'User/Mark')) {
            $this->data->data([
                'empty' => $this->language->get('L_NAVBAR')['L_NOTIFICATION_NO'],
                'status' => 'ok'
            ]);
        }
    }
}