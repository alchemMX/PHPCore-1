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
    protected array $settings = [
        'loggedIn' => true
    ];
    
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {
        if ($this->process->call(type: 'User/Mark', mode: 'direct')) {
            $this->data->data([
                'empty' => $this->language->get('L_NAVBAR')['L_NOTIFICATION_NO'],
                'status' => 'ok'
            ]);
        }
    }
}