<?php

namespace Core;

class Layout
{
    /**
     * Renders a view.
     * @param string $layout PHP File that has to be rendered.
     */
    public static function render(string $layout, $variables = []): void
    {
        extract($variables);
        
        include_once Router::$base . DS . 'layouts' . DS . $layout . '.php';
    }
}