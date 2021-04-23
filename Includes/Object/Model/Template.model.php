<?php

namespace Model;

/**
 * Template
 */
class Template
{    
    /**
     * Returns path to given template file
     *
     * @param  string $path
     * 
     * @throws \Exception\System If given file is not found
     * 
     * @return string|false
     */
    public function require( string $path )
    {
        $templatePath = defined('ERROR_PAGE') ? TEMPLATE_PATH_DEFAULT : TEMPLATE_PATH;

        $paths = [
            ROOT . $templatePath . '/Templates/' . ltrim($path, '/') . '.phtml',
            ROOT . '/Styles/Default/Templates/' . ltrim($path, '/') . '.phtml'
        ];

        foreach ($paths as $_path) {

            if (file_exists($_path)) {
                return $_path;
            }
        }

        throw new \Exception\System('Stránka vyžaduje nexistující vzhled ' . $path . ' s cestou \'' . $templatePath . '\'');
    }

    /**
     * Returns path to given theme file
     *
     * @param  string $path
     * @param bool $useDefaultPath
     * 
     * @throws \Exception\System If given file is not found
     * 
     * @return string
     */
    public function theme( string $path, bool $useDefaultPath = false )
    {
        $templatePath = defined('ERROR_PAGE') ? TEMPLATE_PATH_DEFAULT : TEMPLATE_PATH;

        if ($useDefaultPath === false) {
            if (file_exists(ROOT . ($path = $templatePath . '/Themes' . $path))) {
                return $path;
            }
            throw new \Exception\System('Hledaný vzhledový prvek nebyl nalezen: ' . $path); 
        } else {

            $paths = [
                $templatePath . '/Themes' . $path,
                '/Styles/Default/Themes' . $path
            ];
    
            foreach ($paths as $_path) {
    
                if (file_exists(ROOT . $_path)) {
                    return $_path;
                }
            }
            throw new \Exception\System('Hledaný vzhledový prvek nebyl nalezen: ' . $paths[0]);
        }
    }
}