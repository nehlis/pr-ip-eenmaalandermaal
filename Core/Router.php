<?php

namespace Core;

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
     * @var
     */
    private $dir;
    
    /**
     * @var string[]
     */
    private $routes = [
        '/'            => 'home',
        ''             => 'home',
        '/inloggen'    => 'login',
        '/registreren' => 'register',
        'default'      => '404',
    ];
    
    /**
     * Router constructor.
     * @param $dir
     */
    public function __construct($dir)
    {
        $this->request = $_SERVER['REQUEST_URI'];
        $this->dir     = $dir;
        $this->check();
    }
    
    /**
     * Check if route matches
     */
    private function check()
    {
        foreach ($this->routes as $route => $view) {
            if ($this->request === $route) {
                require $this->dir . '/views/' . $view . '.php';
                
                return;
            }
        }
    }
}