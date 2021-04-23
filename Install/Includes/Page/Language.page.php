<?php

namespace Page;

/**
 * Language page
 */
class Language extends Page
{
    /**
     * Body of this page
     *
     * @return void
     */
    protected function body()
    {   
        $this->templateName = 'Language';

        self::$data->languages = [];

        // LOADS LANGUAGES FROM FOLDER
        foreach (glob(ROOT . '/Languages/*', GLOB_ONLYDIR) as $dir) {
            if (!file_exists($dir . '/Info.json')) continue;
            if (!file_exists($dir . '/Install/Load.language.php')) continue;

            $iso = explode('/', $dir)[count(explode('/', $dir)) - 1];
            $json = json_decode(file_get_contents($dir . '/Info.json'), true);
            self::$data->languages[] = [
                'iso' => $iso,
                'name' => $json['name']
            ];
        }

        // SET LANGUAGE
        $this->process->form(type: 'Language', data: [
            'languageList' => array_column(self::$data->languages, 'iso')
        ]);
    }
}