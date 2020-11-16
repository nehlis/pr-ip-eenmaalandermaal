<?php

// Autoload all classes that are not in same namespace.
spl_autoload_register(function($class) {
    include "functions.php";
});

/**
 * Return stylesheets map URL.
 * @return string
 */
function styles_url(): string
{
    return 'public/styles';
}

/**
 * Returns (java)scripts folder URL.
 * @return string
 */
function scripts_url(): string
{
    return 'public/scripts';
}