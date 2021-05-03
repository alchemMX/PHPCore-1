<?php

namespace Model;

/**
 * Template
 */
class Template
{    
    /**
     * Returns path to template file
     *
     * @param  string $path
     * 
     * @throws \Exception\System If given file is not found
     * 
     * @return string
     */
    public function template( string $path )
    {
        $templatePath = defined('ERROR_PAGE') ? TEMPLATE_PATH_DEFAULT : TEMPLATE_PATH;

        $paths = [
            ROOT . $templatePath . '/Templates/' . ltrim($path, '/'),
            ROOT . '/Styles/Default/Templates/' . ltrim($path, '/')
        ];

        foreach ($paths as $_path) {

            if (file_exists($_path)) {
                return $_path;
            }
        }

        throw new \Exception\System('Stránka vyžaduje nexistující vzhled ' . $path . ' s cestou \'' . $templatePath . '\'');
    }

    /**
     * Returns path to theme file
     *
     * @param  string $path
     * 
     * @throws \Exception\System If given file is not found
     * 
     * @return string
     */
    public function theme( string $path )
    {
        $templatePath = defined('ERROR_PAGE') ? TEMPLATE_PATH_DEFAULT : TEMPLATE_PATH;

        if (file_exists(ROOT . ($path = $templatePath . '/Themes' . $path))) {
            return $path;
        }
        throw new \Exception\System('Hledaný vzhledový prvek nebyl nalezen: ' . $path); 
    }
}