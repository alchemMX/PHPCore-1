<?php

namespace Model;

class System
{
    private $settings;
    
    public function __construct()
    {
        if (!$this->settings) {
            $this->settings = json_decode(file_get_contents(ROOT . '/Includes/Settings/Settings.json'), true);
        }
    }

    public function get( string $value = null )
    {
        if (is_null($value)) {
            return $this->settings;
        }

        return $this->settings[$value] ?? '';
    }

    public function set( $key, $value = null)
    {
        if (is_array($key)) {
            file_put_contents(ROOT . '/Includes/Settings/Settings.json', json_encode(array_merge($this->settings, $key), JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
            return;
        }

        $this->settings[$key] = $value;

        file_put_contents(ROOT . '/Includes/Settings/Settings.json', json_encode($this->settings, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }

    public function install( array $data )
    {
        file_put_contents(ROOT . '/Install/Includes/Settings.json', json_encode(array_merge(json_decode(file_get_contents(ROOT . '/Install/Includes/Settings.json'), true), $data),  JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
    }
}
