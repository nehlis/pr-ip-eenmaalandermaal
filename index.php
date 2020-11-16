<?php

include_once 'helpers/functions.php';

use Core\Router;
use Core\View;

new Router(__DIR__);

View::render('404');