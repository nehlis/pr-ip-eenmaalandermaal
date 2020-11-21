<?php

include_once 'helpers/autoload.php';

use Core\Router;

$uc = new \Controllers\UserController();

var_dump($uc->get(975));


exit();
new Router;