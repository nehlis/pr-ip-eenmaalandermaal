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
        '/uitloggen'    => [
            'view'  => 'logout',
            'title' => 'uitloggen'
        ],
        '/profiel'     => [
            'view'  => 'profile',
            'title' => 'Profiel',
        ],
        '/404'         => [
            'view'  => '404',
            'title' => 'Pagina niet gevonden',
        ],
        '/uctest'      => [
            'view'  => 'uctest',
            'title' => '[TEST] User Controller',
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

    public static function Redirect(string $url)
    {
        // TODO: Vindt oplossing hiervoor...
        echo "<script>window.location = '$url'</script>";
    }
}
