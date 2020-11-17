<?php

include_once 'constants.php';

// Autoload all classes that are not in same namespace.
spl_autoload_register('universalNamespaces');

/**
 * Registers the namespaces cross platform ending with a php tag.
 * @param $class
 */
function universalNamespaces($class): void
{
    include_once str_replace('\\', DS, $class) . '.php';
}