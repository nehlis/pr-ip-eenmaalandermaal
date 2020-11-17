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
            $path = Router::$base . DIRECTORY_SEPARATOR . $folder . DIRECTORY_SEPARATOR . $view . '.php';

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




    public static function testRender($view): void
    {
        echo '<!doctype html>
        <html lang="en">
        
        <head>
        
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
            <!-- StyleSheets -->
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        
            <title>Template Pagina</title>
        </head>
        
        <body>
            <h1>aasdasd</h1>
        
        
        
        
        
            <!-- JavaScript -->
            <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
        </body>
        
        </html>';
    }
}
