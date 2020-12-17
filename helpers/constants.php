<?php

// Directories.
define('DS', DIRECTORY_SEPARATOR);
define('ROOT_DIR', realpath(__DIR__ . DS . '..'));
define('DIST_DIR', DS . 'public' . DS . 'dist');
define('ASSETS_DIR', DS . 'public' . DS . 'assets');
define('VIEWS_DIR', ROOT_DIR . DS . 'views');
define('COMPONENTS_DIR', ROOT_DIR . DS . 'components');
define('LAYOUTS_DIR', ROOT_DIR . DS . 'layouts');

// Helpers.
define('PLACEHOLDER', 'https://sovschoice.com/wp-content/uploads/2020/08/placeholder.png');
define("PLACEHOLDER_ALT", 'https://timmersps.nl/wp-content/uploads/2017/11/img-placeholder.png');
define("REMOTE_URL", "https://iproject3.icasites.nl");
define('IS_WINDOWS', stripos(PHP_OS, 'WIN') === 0);
