<?php

namespace Core;

use Interfaces\IRenderable;

/**
 * Class Component
 * @package Core
 */
class Component implements IRenderable
{
    /**
     * Renders a component (re-usable).
     * @param $renderable
     * @param array $variables
     * @return mixed|void
     */
    public static function render($renderable, $variables = [])
    {
        $componentDirectory = Router::$base . DS . 'components' . DS;
        
        extract($variables);
        require $componentDirectory . $renderable . '.php';
    }
}