<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * @var string[]    $folders    Folders where views and components are stored.
     */
    private static $folders = ['views', 'components'];

    /**
     * Renders a view.
     * @param string    $view       PHP File that has to be rendered. These files are pulled from the 'views' or 'components' folder.
     * @param array     $variables  Optional extra variables.
     */
    public static function render(string $view, $variables = []): void
    {
        foreach (self::$folders as $folder) {
            $basePath = Router::$base . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR;
            $viewPath = $basePath . $view . '.php';
            
            if (file_exists($viewPath)) {
                $file = $viewPath;
                break;
            }
        }
        
        if (isset($file) && file_exists($file)) {
            extract($variables);
            require $file;
        } else {
            exit('Er is iets fout met de routes.');
        }
    }




    public static function testRender($args): void
    {
        
    }
}
