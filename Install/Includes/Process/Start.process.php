<?php

namespace Process;

class Start extends \Process\ProcessExtend
{    
    /**
     * Body of process
     *
     * @return void
     */
    public function process()
    {
        $stats = json_decode(file_get_contents(ROOT . '/Includes/Settings/Statistics.json'), true);

        foreach ($stats as $key => $value) {
            $stats[$key] = 0;
        }

        file_put_contents(ROOT . '/Includes/Settings/Statistics.json', json_encode($stats, JSON_PRETTY_PRINT));

        $this->system->install([
            'db' => false,
            'page' => 1
        ]);
    }
}