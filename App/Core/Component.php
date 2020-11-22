<?php

namespace App\Core;

use App\Interfaces\IRenderable;

/**
 * Class Component
 * @package Core
 */
class Component implements IRenderable
{
    /**
     * Renders a component (re-usable).
     * @param       $renderable
     * @param array $variables
     * @return mixed|void
     */
    public static function render($renderable, $variables = [])
    {
        extract($variables);
        require COMPONENTS_DIR . DS . $renderable . '.php';
    }
}