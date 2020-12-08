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
            'title' => 'Uitloggen',
        ],
        '/profiel'     => [
            'view'  => 'profile',
            'title' => 'Profiel',
        ],
        '/veilingen'    => [
            'view'  =>  'auctions',
            'title' =>  'Veilingen',
        ],
        '/veiling'     => [
            'view'  => 'auction',
            'title' => 'Veiling informatie'
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
        '/pctest'      => [
            'view'  => 'pctest',
            'title' => '[TEST] Phonenumber Controller',
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

    /**
     * Gets referrer page to which it needs to be redirected to
     * @param   array   $exceptions Array of request uri's which need to be ignored.
     * @return  string              referrer request uri.
     */
    public static function getReferrer(array $exceptions): string
    {
        if (!isset($_GET['referrer']) && !in_array($_SERVER['REQUEST_URI'], $exceptions)) {
            return '?referrer=' . $_SERVER['REQUEST_URI'];
        } else {
            return '';
        }
    }
}
