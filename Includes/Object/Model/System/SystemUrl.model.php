<?php

namespace Model\System;

/**
 * SystemUrl
 */
class SystemUrl
{    
    /**
     * @var array $pages Pages URLs
     */
    protected static array $pages = [];
    
    /**
     * Constructor
     */
    public function __construct()
    {
        if (!self::$pages) {
            self::$pages = json_decode(file_get_contents(ROOT . '/Includes/Settings/URL.json'), true);
        }
    }

    /**
     * Returns translated page parameter from URL
     * 
     * @return string
     */
    public function getPage()
    {
        $pages = array_merge(self::$pages['default'], self::$pages['hidden']);

        return isset($pages['/page-']) ? substr($pages['/page-'], 1, 1) : 'page';
    }

    /**
     * Translates URL
     *
     * @param  string $url
     * @param  bool $hidden If true - uses also hidden URL
     * 
     * @return string
     */
    public function translate( string $url, bool $hidden = true )
    {
        $pages = $hidden ? array_merge(array_flip(self::$pages['default']), array_flip(self::$pages['hidden'])) : array_flip(self::$pages['default']);

        $url = '/' . trim($url, '/') . '/';
        $url = strtr($url, $pages);

        return $url;
    }

    /**
     * Builds url
     *
     * @param  string $url
     * 
     * @return string
     */
    public function build( string $url )
    {
        $_url = $url;
        if ($url === '/' or empty($url)) {
            return '/';
        }
        
        $url = '/' . implode('/', array_filter(explode('/', $url))) . '/';
        
        $url = $this->translate($url, false);
        $url = str_ireplace(array_keys(self::$pages['default']), array_values(self::$pages['default']), $url);

        if (preg_match('/[#]/', $url)) {
            $url = rtrim($url, '/');
        }

        $parse = parse_url($_url);

        if (isset($parse['scheme'])) {
            $url = ltrim($url, '/');
        }

        if (isset($parse['fragment'])) {
            $url = rtrim($url, '/');
        }

        return $url;
    }
}
