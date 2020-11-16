<?php

namespace Interfaces;

/**
 * Interface IModel
 * @package Interfaces
 */
interface IModel
{
    /**
     * Set values of model.
     * @param array $values
     */
    function init(array $values): void;
}