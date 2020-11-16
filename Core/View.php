<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * @var string[]
     */
    private static $folders = ['views', 'components'];
    
    /**
     * Renders a view with parameter options.
     * @param $view
     * @param array $variables
     */
    public static function render($view, $variables = []): void
    {
        foreach (self::$folders as $folder) {
            $path = Router::$base . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $view . '.php';
            
            if (file_exists($path)) {
                $file = $path;
                break;
            }
        }
        
        if (isset($file) && file_exists($file)) {
            extract($variables);
            require $file;
        }
    }
}