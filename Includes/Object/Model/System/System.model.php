<?php

namespace Model\System;

/**
 * System class
 */
class System
{
    /**
     * @var \Model\System\SystemUrl $url SystemUrl
     */
    public \Model\System\SystemUrl $url;

    /**
     * @var \Model\System\SystemSettings $settings SystemSettings
     */
    public \Model\System\SystemSettings $settings;

    /**
     * @var \Model\System\SystemTemplate $template SystemTemplate
     */
    public \Model\System\SystemTemplate $template;

    /**
     * @var \Model\System\SystemStatistics $stats SystemStatistics
     */
    public \Model\System\SystemStatistics $stats;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->settings = new SystemSettings();
        $this->template = new SystemTemplate($this->settings->get('site.template'));
        $this->stats = new SystemStatistics();
        $this->url = new SystemUrl();
    }
}
