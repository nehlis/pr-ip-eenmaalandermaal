<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * Renders a view with parameter options.
     * @param $view
     * @param array $variables
     */
    public static function render($view, $variables = [])
    {
        $file = Router::getBaseDir() . '/views/' . $view . '.php';
        
        if (file_exists($file)) {
            extract($variables);
            require $file;
        }
    }
}