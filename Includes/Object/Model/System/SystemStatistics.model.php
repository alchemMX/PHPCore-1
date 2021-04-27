<?php

namespace Model\System;

/**
 * SystemStatistics
 */
class SystemStatistics
{
    /**
     * @var array $statistics Statistics data
     */
    public static array $statistics = [];
        
    /**
     * Constructor
     */
    public function __construct()
    {
        if (!self::$statistics) {
            self::$statistics = json_decode(file_get_contents(ROOT . '/Includes/Settings/Statistics.json'), true);
        }
    }
    
    /**
     * Returns value from statistics
     *
     * @param  string $value
     * 
     * @return int
     */
    public function get( string $value = null )
    {
        return self::$statistics[$value] ?? 0;
    }
    
    /**
     * Sets value to statistics
     *
     * @param  string $key
     * @param  int $value
     * 
     * @return void
     */
    public function set( string $key, int $value )
    {
        if (!isset(self::$statistics[$key])) {
            self::$statistics[$key] = 0;
        }

        self::$statistics[$key] = (int)self::$statistics[$key] + (int)$value;

        file_put_contents(ROOT . '/Includes/Settings/Statistics.json', json_encode(self::$statistics, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
