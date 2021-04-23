<?php

namespace Model\System;

/**
 * System class
 */
class System
{
    /**
     * @var \Model\System\SystemUrl $url Pages url name class
     */
    public \Model\System\SystemUrl $url;

    /**
     * @var \Model\System\SystemSettings $settings List of PHPCore configuration
     */
    public \Model\System\SystemSettings $settings;

    /**
     * @var \Model\System\SystemTemplate $template List of PHPCore configuration
     */
    public \Model\System\SystemTemplate $template;

    /**
     * @var \Model\System\SystemStatistics $config List of PHPCore configuration
     */
    public \Model\System\SystemStatistics $stats;
    
    /**
     * Constructor
     * 
     * @return object
     */
    public function __construct()
    {
        $this->settings = new SystemSettings();
        $this->template = new SystemTemplate($this->settings->get('site.template'));
        $this->stats = new SystemStatistics();
        $this->url = new SystemUrl();
    }
}
