<?php

namespace Core;

/**
 * Class View
 * @package Core
 */
class View
{
    /**
     * @var string[] $folders Folders where views and components are stored.
     */
    private static $folders = ['views', 'components'];
    
    /**
     * Renders a view.
     * @param string $view PHP File that has to be rendered. These files are pulled from the 'views' or 'components' folder.
     * @param array $variables Optional extra variables.
     * @param bool $isLayout
     */
    public static function render(string $view, $variables = [], $isLayout = false): void
    {
        foreach (self::$folders as $folder) {
            $basePath = Router::$base . DS . $folder . DS;
            $viewPath = $basePath . $view . '.php';
            
            if (file_exists($viewPath)) {
                $file = $viewPath;
                break;
            }
        }
        
        if (isset($file) && file_exists($file)) {
            if ($isLayout) {
                self::layout($file, $variables);
            } else {
                extract($variables);
                require $file;
            }
        } else {
            exit('Er is iets fout met de routes.');
        }
    }
    
    /**
     * Renders with a layout (for page views).
     * @param $file
     * @param $variables
     */
    public static function layout($file, $variables)
    {
        Layout::render('head', $variables);
        
        extract($variables);
        require $file;
        
        Layout::render('footer');
    }
}
