<?php

namespace App\Core;

/**
 * Class Router
 * @package Core
 */
class Router
{
    /**
     * @var mixed
     */
    private $request;

    /**
     * @var string[]
     */
    private $routes = [
        '/'            => [
            'view'  => 'home',
            'title' => 'Homepagina',
        ],
        ''             => [
            'view'  => 'home',
            'title' => 'Homepagina',
        ],
        '/inloggen'    => [
            'view'  => 'login',
            'title' => 'Inloggen',
        ],
        '/registreren' => [
            'view'  => 'register',
            'title' => 'Registreren',
        ],
        '/uitloggen'   => [
            'view'  => 'logout',
            'title' => 'uitloggen',
        ],
        '/profiel'     => [
            'view'  => 'profile',
            'title' => 'Profiel',
        ],
        '/404'         => [
            'view'  => '404',
            'title' => 'Pagina niet gevonden',
        ],
        '/actest'      => [
            'view'  => 'actest',
            'title' => '[TEST] User Controller',
        ],
        '/ictest'      => [
            'view'  => 'ictest',
            'title' => '[TEST] Item Controller',
        ],
    ];

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $this->request = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
        $this->check();
    }

    /**
     * Check if route matches and render matching view.
     */
    private function check(): void
    {
        foreach ($this->routes as $key => $route) {
            if ($this->request === $key) {
                View::render(null, $route);

                return;
            }
        }

        View::render(null, $this->routes['/404']);
    }

    public static function redirect(string $url): void
    {
        // TODO: Vindt oplossing hiervoor...
        echo "<script>window.location = '$url'</script>";
    }

    public static function getReferrer(array $exceptions): string
    {
        if (!isset($_GET['referrer']) && !in_array($_GET['referrer'], $exceptions)) {
            return '?referrer=' . $_SERVER['REQUEST_URI'];
        } else {
            return '?referrer=' . $_GET['REQUEST_URI'];
        }
    }
}
