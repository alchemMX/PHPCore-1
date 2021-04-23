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
     * @var string $templateName Name of default template
     */
    public string $templateName;
    
    /**
     * Constructor
     *
     * @param  mixed $template Default template name
     */
    public function __construct( string $template )
    {
        if (!self::$template) {
            self::$template = json_decode(file_get_contents(ROOT . '/Styles/' . $template . '/Info.json'), true);
        }
    }
    
    /**
     * Returns value from template .json file
     *
     * @param  mixed $key
     * 
     * @return mixed
     */
    public function get( string $key = null )
    {
        if (is_null($key)) {
            return self::$template;
        }

        return self::$template[$key] ?? '';
    }
}
