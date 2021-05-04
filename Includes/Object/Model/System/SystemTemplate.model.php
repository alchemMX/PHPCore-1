<?php

namespace Model\System;

/**
 * SystemTemplate
 */
class SystemTemplate
{
    /**
     * @var array $template Settings about current template
     */
    public static array $template = [];
    
    /**
     * Constructor
     *
     * @param  string $template Default template name
     */
    public function __construct( string $template )
    {
        if (!self::$template) {
            self::$template = json_decode(file_get_contents(ROOT . '/Styles/' . $template . '/Info.json'), true);
        }
    }
    
    /**
     * Returns value from template settings
     *
     * @param  string $key
     * 
     * @return mixed
     */
    public function get( string $key )
    {
        return self::$template[$key] ?? '';
    }
}
