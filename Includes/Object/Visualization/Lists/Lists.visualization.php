<?php

namespace Visualization\Lists;

/**
 * Lists
 */
class Lists extends \Visualization\Visualization
{
    /**
     * @var array $button Pre-defined buttons data
     */
    private array $button = [
        'add' => [
            'href' => '/add/'
        ],
        'info' => [
            'icon' => 'fas fa-info',
            'href' => '/show/{id}'
        ],
        'up' => [
            'ajax' => 'up',
            'icon' => 'fas fa-caret-up'
        ],
        'down' => [
            'ajax' => 'down',
            'icon' => 'fas fa-caret-down'
        ],
        'edit' => [
            'href' => '/show/{id}/',
            'icon' => 'fas fa-pencil-alt'
        ],
        'delete' => [
            'ajax' => 'delete',
            'icon' => 'fas fa-trash'
        ]
    ];

    /**
     * Executes code for every object
     *
     * @param  \Visualization\Visualization $visual
     * 
     * @return void|false
     */
    protected function each_clb( \Visualization\Visualization $visual )
    {
        foreach ((array)$visual->obj->get->button() as $btnName => $btn) {

            $btn['data'] ??= [];

            // PREPEND PATH TO TEMPLTE IF IS SET
            if (isset($btn['options']['template'])) {
                $btn['options']['template'] = ROOT . '/Includes/Admin/Styles/Default/Templates/Blocks/Lists' . $btn['options']['template'];
            }

            // MERGE BUTTON DATA WITH PREDEFINED IF IS SET
            if (isset($this->button[$btnName])) {
                $btn['data'] = array_merge($this->button[$btnName], $btn['data']);
            }

            // IF BUTTON HAS HREF PARAMETER
            if (isset($btn['data']['href'])) {

                // ASSIGN VARIABLES TO URL
                foreach ($visual->obj->get->data() as $key => $value) {
                    if (!is_array($value)) {
                        $btn['data']['href'] = strtr($btn['data']['href'], ['{' . $key . '}' => $value]);
                    }
                }

                switch (substr($btn['data']['href'], 0, 1)) {
            
                    case '$':
                        $btn['data']['href'] = substr($btn['data']['href'], 1);
                    break;

                    case '~':
                        $btn['data']['href'] = $this->system->url->build(substr($btn['data']['href'], 1));
                    break;
    
                    default:
                        $btn['data']['href'] = $this->system->url->build(URL . $btn['data']['href']);
                    break;
                }
            }

            // SET EDITED DATA TO BUTTON
            $visual->obj->set->button($btnName, $btn);
        }
    }
}