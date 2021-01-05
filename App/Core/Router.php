<?php

namespace App\Core;

use App\Services\AuthService;

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
        '/'           => [
            'view'  => 'home',
            'title' => 'Homepagina',
            'auth'  => false,
        ],
        ''                => [
            'view'  => 'home',
            'title' => 'Homepagina',
            'auth'  => false,
        ],
        '/hoewerkthet' => [
            'view'  => 'information',
            'title' => 'Hoe werkt het?',
            'auth'  => false
        ],
        '/inloggen'       => [
            'view'  => 'login',
            'title' => 'Inloggen',
            'auth'  => false,
        ],
        '/registreren'    => [
            'view'  => 'register',
            'title' => 'Registreren',
            'auth'  => false,
        ],
        '/uitloggen'      => [
            'view'  => 'logout',
            'title' => 'Uitloggen',
            'auth'  => false,
        ],
        '/profiel'        => [
            'view'  => 'profile',
            'title' => 'Profiel',
            'auth'  => true,
        ],
        '/veilingen'      => [
            'view'  => 'auctions',
            'title' => 'Veilingen',
            'auth'  => false,
        ],
        '/veiling'        => [
            'view'  => 'auction',
            'title' => 'Veiling informatie',
            'auth'  => false,
        ],
        '/veilingen/toevoegen'     => [
            'view'  => 'add-auction',
            'title' => 'Veiling Toevoegen',
            'auth'  => true,
        ],
        '/auction-users'     => [
            'view'  => 'auction-users',
            'title' => 'Gebruikers accounts'
        ],
        '/auctions-manage'     => [
            'view'  => 'auctions-manage',
            'title' => 'Veilingen'
        ],
        '/mijn-veilingen' => [
            'view'  => 'personal-auctions',
            'title' => 'Mijn veilingen',
            'auth'  => true,
        ],
        '/404'         => [
            'view'  => '404',
            'title' => 'Pagina niet gevonden',
            'auth'  => false,
        ],
        '/actest'      => [
            'view'  => 'actest',
            'title' => '[TEST] User Controller',
            'auth'  => false,
        ],
        '/ictest'      => [
            'view'  => 'ictest',
            'title' => '[TEST] Item Controller',
            'auth'  => false,
        ],
        '/pctest'      => [
            'view'  => 'pctest',
            'title' => '[TEST] Phonenumber Controller',
            'auth'  => false,
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
                if ($route['auth']) {
                    AuthService::checkAuth();
                }

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
        if (!isset($_GET['referrer']) && !in_array($_SERVER['REQUEST_URI'], $exceptions, true)) {
            return '?referrer=' . $_SERVER['REQUEST_URI'];
        }

        return '';
    }
}
