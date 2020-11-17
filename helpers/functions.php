<?php

// Autoload all classes that are not in same namespace.
spl_autoload_register('universalDirectories');

define('DS', DIRECTORY_SEPARATOR);

/**
 * Registers the directories cross platform ending with a php tag.
 * @param $class
 */
function universalDirectories($class): void
{
    include_once str_replace('\\', DS, $class) . '.php';
}


/**
 * Return stylesheets map URL.
 * @return string
 */
function styles_url(): string
{
    return 'public/assets/css';
}

/**
 * Returns (java)scripts folder URL.
 * @return string
 */
function scripts_url(): string
{
    return 'public/assets/js';
}