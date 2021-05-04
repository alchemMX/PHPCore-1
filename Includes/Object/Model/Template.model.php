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
        $templatePath = TEMPLATE_PATH;
        $template = TEMPLATE;
        if (defined('ERROR_PAGE')) {
            $templatePath =  TEMPLATE_PATH_DEFAULT;
            $template = TEMPLATE_DEFAULT;
        }

        $paths = [
            ROOT . $templatePath . '/' . $template . '/Templates/' . ltrim($path, '/'),
            ROOT . $templatePath . '/Default/Templates/' . ltrim($path, '/')
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
        $templatePath = TEMPLATE_PATH;
        $template = TEMPLATE;
        if (defined('ERROR_PAGE')) {
            $templatePath =  TEMPLATE_PATH_DEFAULT;
            $template = TEMPLATE_DEFAULT;
        }

        if (file_exists(ROOT . ($path = $templatePath . '/' . $template . '/Themes' . $path))) {
            return $path;
        }
        throw new \Exception\System('Hledaný vzhledový prvek nebyl nalezen: ' . $path); 
    }
}