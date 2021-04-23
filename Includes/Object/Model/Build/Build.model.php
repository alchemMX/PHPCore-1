<?php

namespace Model\Build;

/**
 * Build
 */
class Build extends \Model\Model
{  
    /**
     * @var object $url Builder for url
     */
    public $url;

    /**
     * @var object $date Builder for date
     */
    public $date;

    /**
     * @var object $user Builder for user 
     */
    public $user;
    
    /**
     * Loads builders
     *
     * @return void
     */
    public function load()
    {
        $this->url = new BuildUrl();
        $this->date = new BuildDate();
        $this->user = new BuildUser();
        $this->user->url = $this->url;
    }

    /**
     * Builds max allowed image size
     *
     * @return string
     */
    public function size()
    {
        return strtr($this->language->get('L_MAX_IMAGE_SIZE'), ['{size}' => $this->system->settings->get('max_image_size') / 1024]);
    }
}