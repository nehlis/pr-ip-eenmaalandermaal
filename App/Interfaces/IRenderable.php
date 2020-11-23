<?php

namespace App\Interfaces;

/**
 * Interface IRenderable
 * @package Interfaces
 */
interface IRenderable
{
    /**
     * Renders the template.
     * @param $renderable
     * @param $variables
     * @return mixed
     */
    public static function render($renderable, $variables);
}