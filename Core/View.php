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
     * @param String    $view       PHP File that has to be rendered. These files are pulled from the 'views' or 'components' folder.
     * @param array     $variables  Optional extra variabeles.
     */
    public static function render($view, $variables = []): void
    {
        foreach (self::$folders as $folder) {
            $path = Router::$base . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $view;
            
            if (file_exists($path)) {
                $file = $path;
                break;
            } else {
                // Show 404 page when file does not exist.
                $file = Router::$base . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . "404.php";
                break;
            }
        }
        
        if (isset($file) && file_exists($file)) {
            extract($variables);
            require $file;
        }
    }
}