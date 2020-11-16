<?php

// Autoload all classes that are not in same namespace.
spl_autoload_register(function($class) {
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    
    file_exists($class) ? include_once $class : null;
});

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