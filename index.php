
<?php
$request = $_SERVER['REQUEST_URI'];

// ROUTER
switch ($request) {
    case '/':
        require __DIR__ . '/views/home.php';
        break;
    case '':
        require __DIR__ . '/views/home.php';
        break;
    case '/inloggen':
        require __DIR__ . '/views/login.php';
        break;
    case '/registreren':
        require __DIR__ . '/views/register.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
